<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 30/04/2016
 * Time: 21:55
 */

namespace App\Helpers;


use App\Author;
use App\Bibliography;
use App\Carbon;
use App\CarbonType;
use App\Molecule;
use App\ShiftLimit;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MolUploader
{
    private $log;
    private $errors;
    private $warnings;
    private $molecule;
    private $carbons;
    private $bibliography;
    private $author;


    /**
     * Función principal que inicia el proceso de guardado de los datos de una molécula en la base de datos.
     * @param $moleculeData Datos de la molécula.
     */
    public function insert($moleculeData)
    {
        //Para asegurarnos de que no hay fallo a la hora de introducir datos, reinicia todas las variables cada vez que se introduce una nueva molécula.
        $this->log = array();
        $this->errors = array();
        $this->warnings = array();
        $this->molecule = null;
        $this->carbons = array();
        $this->bibliography = null;
        $this->author = null;
        //$limits=$this->loadLimits();
        //El primer paso es comprobar si la referencia existe, de este modo si esa molécula ya existe obviamos el resto, agilizando el proceso en caso de que se repita.
        $mTemp = Molecule::where('reference', trim($moleculeData['reference']))->first();
        $rep=false;
        if ($moleculeData['id']=="") {
            if ($mTemp!=null) {
                $mTemp2=DB::select('select solvent from molecules where reference="'.$moleculeData['reference'].'"');
                for ($i=0; $i <sizeof($mTemp2) ; $i++) {
                    if($mTemp2[$i]->solvent==$moleculeData['solvent']){
                        $rep=true;
                        break;
                    }
                }
            }
        }
        if ($rep) {
            $this->errors[] = "Ya existe molécula con referencia '".$mTemp->reference."', disolvente '" . $mTemp2[$i]->solvent."' e ID: '".$mTemp->id."'";
        }else{
            // CORRECCIÓN: Verificar que author existe y es un array antes de cargarlo
            if (!empty($moleculeData['author']) && is_array($moleculeData['author'])) {
                $this->loadAuthor($moleculeData['author']);
            } else {
                // Crear autor vacío si no hay datos
                $this->loadAuthor([
                    'author' => '',
                    'email' => '',
                    'organization' => '',
                    'country' => ''
                ]);
            }
            
            //Crea la bibliografía
            // CORRECCIÓN: Verificar que bibliography existe
            $this->loadBibliography($moleculeData['bibliography'] ?? []);
            
            //Crea la molécula
            $this->loadMolecule($moleculeData);
            
            //Crear carbonos.
            // CORRECCIÓN: Verificar que carbons existe y es un array
            $this->loadCarbons($moleculeData['carbons'] ?? []);
            
            //Se obtienen el resto de campos que hay que calcular.
            $this->loadSpecial();
            //Se buscan el resto de errores
            $error = $this->checkErrors();

            // Solo guarda si en el paso previo no ha dado error
            // y no ha encontrado una molecula con smile/disolvente duplicada
            if (!$error) {
                //Se guarda la molécula y se genera el log de inserción
                $this->saveMolecule();
            }
        }
        $status = sizeof($this->errors) == 0 ? "ok" : "failed";
        //Creamos el log de la molecula
        $this->log['ref'] = trim($moleculeData['reference']);
        $this->log['status'] = $status;
        $this->log['errors'] = $this->errors;
        $this->log['warnings'] = $this->warnings;
        if ( array_key_exists('nRow',$moleculeData)) {
             $this->log['nRow']=$moleculeData['nRow'];
        }

    }


    /**
     * Retorna los datos del log de la molécula que se encuentra actualmente en proceso de guardado.
     * @return array, los datos del log de la molécula actual.
     */
    public function getLog()
    {
        return $this->log;
    }

    /*
     * Busca errores adicionales según criterios específicados en los datos de la molécula.
     */
    private function checkErrors()
    {
        $error = false;
        // BUSQUEDA DE ERRORES
        //Búsqueda de duplicado en la base de datos (Necesita aplicación java).
        //Solo busca si la operación es una inserción de nueva molécula. (no tiene id predefinida
        if (empty($this->molecule->id)) {
            try {
                $dup = Molecule::searchDuplicate($this->molecule->smiles, $this->molecule->solvent);
                if ($dup != 0) {
                    $error = true;
                    $mTemp = Molecule::where('id', $dup)->first();
                    $reference = 'No encontrada en C13';
                    if (!empty($mTemp)) {
                        $reference = $mTemp->reference;
                    }

                    $this->errors[] = "Molécula duplicada con referencia '".$reference."'e ID: '" . $dup . "'";
                }
            } catch (\Exception $e) {
                $error = true;
                $this->errors[] = $e->getMessage();
            }
        }
        //Búsqueda de carbonos con desplazamiento fuera de rango.
        //ESTA FUNCIÓN NECESITA DESARROLLO LOS LIMITES QUE HAY AHORA MISMO HACEN FALLAR MUCHOS CARBONOS
        /*
        foreach ($carbons as $carbon) {
            if (array_key_exists(strtoupper($carbon->carbonType), $this->limits)) {
                $min = $this->limits[strtoupper($carbon->carbonType)]['min'];
                $max = $this->limits[strtoupper($carbon->carbonType)]['max'];
                if ($carbon->shift < $min || $carbon->shift > $max) {
                    $errors[] .= $carbon->carbonType . " Num: " . $carbon->num2 . " Des: " . $carbon->shift . " **Desplazamiento fuera de rango**";
                }
            }
        }
        */

       return $error;
    }

    /*
     * Método final que hace la conexión con la base de datos para guardar definitivamente los datos en la base de datos.
     */
    private function saveMolecule()
    {
        $error = null;

        $data = array('bibliography' => $this->bibliography, 'author' => $this->author, 'molecule' => $this->molecule, 'carbons' => $this->carbons);

        try {
            DB::transaction(function () use ($data) {
                //Verificar bibliografía y cargar el código de la bibliografía
                $biblioSearch = $data['bibliography']->getExisting();

                if (!empty($biblioSearch)) {
                    $data['bibliography'] = $biblioSearch;
                } else {
                    $data['bibliography']->save();
                }

                //Una vez tenemos la bibliografía se guarda la id en la molécula.
                $data['molecule']->bibliography = $data['bibliography']->id;

                //Se repite el mismo paso esta vez con el autor.
                $authorSearch = $data['author']->getExisting();
                if (!empty($authorSearch)) {
                    $data['author'] = $authorSearch;
                } else {
                    $data['author']->save();
                }
                $data['molecule']->authorId = $data['author']->id;

                $data['molecule']->save();


                //Una vez guardada, la id asignada a la molécula se le asigna a todos los carbonos de esa molécula.
                foreach ($data['carbons'] as $carbon) {
                    $carbon->molecularId = $data['molecule']->id;
                    $carbon->save();
                }

                //Se borra los carbonos que se han borrado en la modificación.
                $cIds = array();
                foreach ($data['carbons'] as $carbon) {
                    $cIds[] = $carbon->id;
                }
                Carbon::where('molecularId', $data['molecule']->id)->whereNotIn('id', $cIds)->delete();

                CarbonTypesCalculator::saveCarbonTypes($data['molecule']->id, $data['molecule']->smilesNumeration, $data['molecule']->molecularFormula);
                Cache::flush();
            });
        } catch (QueryException $e) {
            Log::info($e->getMessage());
            $this->error = "Error en la base de datos " . $e->getMessage();
        } catch (\PDOException $e) {
            Log::info($e->getMessage());
            $this->error = "Error en la base de datos " . $e->getMessage();
        }
    }


    /*
     * Carga los límites de desplazamiento de carbono.
     */
    private function loadLimits()
    {
        $models = ShiftLimit::select('carbonType', 'min', 'max')->get();
        foreach ($models as $model) {
            $limits[$model->carbonType] = array('min' => $model->min, 'max' => $model->max);
        }
        return $limits;
    }

    /*
     * Genera el modelo eloquent del autor con los datos especificados.
     */
    private function loadAuthor($authorData)
    {
        // CORRECCIÓN: Asegurar que authorData es un array y tiene las claves necesarias
        if (!is_array($authorData)) {
            $authorData = [];
        }
        
        $author = new Author();
        $author->author = isset($authorData['author']) ? trim($authorData['author']) : '';
        $author->email = isset($authorData['email']) ? trim($authorData['email']) : '';
        $author->organization = isset($authorData['organization']) ? trim($authorData['organization']) : '';
        $author->country = isset($authorData['country']) ? trim($authorData['country']) : '';
        $this->author = $author;
    }

    /*
     * Crea el modelo eloquent de la bibliografía con los datos especificados.
     */
    public function loadBibliography($bibligraphyData)
    {
        // CORRECCIÓN: Asegurar que bibliographyData es un array
        if (!is_array($bibligraphyData)) {
            $bibligraphyData = [];
        }
        
        $bibliography = new Bibliography();
        $bibliography->authors = isset($bibligraphyData['authors']) ? $bibligraphyData['authors'] : '';
        $bibliography->year = isset($bibligraphyData['year']) ? $bibligraphyData['year'] : '';
        $bibliography->magazine = isset($bibligraphyData['magazine']) ? $bibligraphyData['magazine'] : '';
        $bibliography->volume = isset($bibligraphyData['volume']) ? $bibligraphyData['volume'] : '';
        $bibliography->page = isset($bibligraphyData['page']) ? $bibligraphyData['page'] : '';
        $bibliography->doi = isset($bibligraphyData['doi']) ? $bibligraphyData['doi'] : '';
        $this->bibliography = $bibliography;
    }

    /*
     * Crea el modelo eloquent de la molécula con los datos especificados.
     */
    private function loadMolecule($moleculeData)
    {
        //Si la id de la molecula está vacía, es una nueva molécula.
        //Si la id no está vacía, hay que cargar la molécula con esa id y modificarla.
        //En caso de solicitar una id que no existe se considera también molécula nueva.
        $molecule = Molecule::where('id', trim($moleculeData['id']))->first();
        if (empty($molecule)) {
            $molecule = new Molecule();
        }
        $molecule->reference = trim($moleculeData['reference']);
        $molecule->state = trim($moleculeData['state']);
        $molecule->name = trim($moleculeData['name']);
        $molecule->semiSystematicName = trim($moleculeData['semiSystematicName']);
        $molecule->family = trim($moleculeData['family']);
        $molecule->subFamily = trim($moleculeData['subFamily']);
        $molecule->subSubFamily = trim($moleculeData['subSubFamily']);
        $molecule->smilesNumeration = trim($moleculeData['smilesNumeration']);
        $molecule->jmeNumeration = trim($moleculeData['jmeNumeration']);
        $molecule->solvent = trim($moleculeData['solvent']);
        $molecule->publicCom = trim($moleculeData['publicCom']);
        $molecule->privateCom = trim($moleculeData['privateCom']);
        $this->molecule = $molecule;
    }

    /*
     * Crea los modelos de los carbonos a partir de los datos aportados.
     */
    private function loadCarbons($carbonsData)
    {
        // CORRECCIÓN: Asegurar que carbonsData es un array
        if (!is_array($carbonsData)) {
            $carbonsData = [];
        }
        
        //Repetimo el paso de las moléculas, si tiene una id asignada hay que modificar el carbono y no crear uno nuevo.
        $numerations = array();
        foreach ($carbonsData as $carbonData) {
            // CORRECCIÓN: Verificar que carbonData tiene las claves necesarias
            if (!is_array($carbonData)) {
                continue;
            }
            
            $numeration = isset($carbonData['numeration']) ? trim($carbonData['numeration']) : '';
            $carbonType = isset($carbonData['carbonType']) ? trim($carbonData['carbonType']) : '';
            $shift = isset($carbonData['shift']) ? trim($carbonData['shift']) : '';
            $id = isset($carbonData['id']) ? trim($carbonData['id']) : '';
            $num2 = isset($carbonData['num2']) ? trim($carbonData['num2']) : '';
            
            if (in_array($numeration, $numerations)) {
                $this->errors[] = "Numeración de carbono repetida " . $numeration;
                break;
            } else {
                if (empty($carbonType) || empty($shift) || empty($numeration)) {
                    $this->warnings[] = "Faltan datos en uno de los carbonos";
                }
                $carbon = Carbon::where('id', $id)->first();
                if (empty($carbon)) {
                    $carbon = new Carbon();
                }
                $carbon->carbonType = $carbonType;
                $carbon->shift = floatval(str_replace(",", ".", $shift));
                $carbon->numeration = $numeration;
                $numerations[] = $numeration;
                $carbon->num2 = empty($num2) ? Conversor::getNumerationInverse($numeration) : $num2;
                $this->carbons[] = $carbon;
            }
        }
    }


    /*
     * Encapsula la carga de los datos que deben ser calculados.
     */
    private function loadSpecial()
    {
        $this->molecule->smiles = Conversor::toSmiles($this->molecule->smilesNumeration);
        $this->molecule->smilesDisplacement = Conversor::toSmileDis($this->molecule->smilesNumeration, $this->carbons);
        $this->molecule->jme = Conversor::toJme($this->molecule->jmeNumeration);
        $this->molecule->jmeDisplacement = Conversor::toJmeDis($this->molecule->jmeNumeration, $this->carbons);
        $this->molecule->molecularFormula = Conversor::jmeToFormula($this->molecule->jmeNumeration);
        $this->molecule->molecularWeight = Conversor::atomicWeight($this->molecule->molecularFormula);
    }
}