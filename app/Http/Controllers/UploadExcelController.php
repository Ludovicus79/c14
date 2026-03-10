<?php

namespace App\Http\Controllers;

use App\Bibliography;
use App\Helpers\Conversor;
use App\Helpers\LogWriter;
use App\Helpers\MolUploader;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SheetToArrayImport;

class UploadExcelController extends Controller
{
    private $excel = array();
    private $default;
    private $preBiblio;
    private $author;
    private $molecule;
    private $molecules;
    private $molUploader;
    private $nRow;

    /*
     * Devuelve la vista solicitada.
     */
    public function get(Request $request)
    {
        return view('admin.upload');
    }

    /*
     * Responde a la petición POST con la carga del excell e iniciar el proceso de lectura, carga y guardado.
     */
    public function post(Request $request)
    {
        set_time_limit(3000);
        $validateFile = [
            'file' => 'mimes:xls,xlm,xla,xlc,xlt,xlw,ods,xlsx'
        ];
        $this->validate($request, $validateFile);

        // CORRECCIÓN: Inicializar arrays para evitar null
        $this->author = [
            'author' => '',
            'email' => '',
            'organization' => '',
            'country' => ''
        ];
        
        $this->default = [
            'state' => '',
            'family' => '',
            'subFamily' => '',
            'subSubFamily' => ''
        ];

        $this->molUploader = new MolUploader();

        $this->preBiblio = new Bibliography();
        //Se leen los datos

        $this->readExcel($request);

        $this->formatExcel();
        $this->log['author'] = $this->author['author'];
        // var_dump($this->log);
        // exit();
        $logPath = (LogWriter::writeExcelLog($this->log));
        return redirect(url('/admin/logs/' . $logPath));
    }

    /*
     * A partir del array con los datos del excel controla el proceso de guardado de las moléculas por separado.
     */
    public function formatExcel()
    {
        $this->nRow=1;
        //var_dump($this->excel);
        //exit();
        foreach ($this->excel as $row) {
            $this->nRow++;
            $row = array_values($row);
            if (!array_filter($row)) {
                continue;
            }

            if (!empty($row[0])) {
                if (strtoupper(trim($row[0])) == 'FILA ESPECIAL') {
                    $this->loadSpecial($row);
                } else {
                    //Si ya hay algúna molécula iniciada hay que salvarla antes de empezar la siguiente.
                    if (!empty($this->molecule)) {
                        //print_r('Insertando molécula:');
                        //print_r($this->molecule);
                        //var_dump($this->molecule);
                        $this->molUploader->insert($this->molecule);
                        $this->log['moleculas'][] = $this->molUploader->getLog();
                    }
                    //Nueva molécula
                    $this->newMolecule($row);
                }
            } else {
                if (empty($row[1]) && empty($row[2]) && empty($row[3]) && empty($row[4]) && empty($row[5]) && empty($row[6])) {
                    $this->newCarbon($row);
                }
            }
            //$this->log['moleculas']['nRow']=$this->nRow;
        }
        //Guarda la última molécula
        $this->molUploader->insert($this->molecule);
        $this->log['moleculas'][] = $this->molUploader->getLog();
    }


    /**
     * Crea una molécula nueva.
     * @param $row Array que corresponde a la fila que contiene los datos de la nueva molécula.
     */
    public
    function newMolecule($row)
    {
        //Se reinician las variables necesrias
        $this->molecule['carbons'] = array();
        $this->molecule = array();
        //Forzar error en query
        //$this->molecule->id = '1';
        //Se cargan todos los datos en las variables de clase.
        $this->molecule['id'] = "";
        $this->molecule['reference'] = trim($row[0]);
        $this->molecule['state'] = (!empty(trim($row[1]))) ? trim($row[1]) : $this->default['state'];
        $this->molecule['name'] = trim($row[2]);
        $this->molecule['semiSystematicName'] = trim($row[3]);
        $this->molecule['family'] = trim($row[4]);
        $this->molecule['subFamily'] = trim($row[5]);
        $this->molecule['subSubFamily'] = trim($row[6]);
        $this->checkDefault();
        if (!empty(trim($row[7]))) {
            preg_match("|(.*_.*_)|", $this->molecule['reference'], $matches);
            $this->preBiblio = Conversor::formatBiblio(trim($row[7]));
            $this->molecule['bibliography'] = $this->preBiblio;
            // CORRECCIÓN: Verificar si existe $matches[1] antes de usarlo
            $this->preReference = isset($matches[1]) ? $matches[1] : '';
        } else {
            //print_r('Posible espacio en blanco');
            //print_r($this->molecule['reference']);

            preg_match("|(.*_.*_)|", $this->molecule['reference'], $matches);
            // CORRECCIÓN: Verificar si existe $matches[1] antes de compararlo
            if (isset($matches[1]) && $this->preReference == $matches[1]) {
                Log::info("ref" . $this->preReference);
                Log::info($matches[1]);
                $this->molecule['bibliography'] = $this->preBiblio;
            } else {
                $this->molecule['bibliography'] = Conversor::formatBiblio("");
            }
        }

        // CORRECCIÓN: Asegurar que author siempre sea un array válido
        $this->molecule['author'] = $this->author ?? [
            'author' => '',
            'email' => '',
            'organization' => '',
            'country' => ''
        ];
        $this->molecule['smilesNumeration'] = trim($row[8]);
        $this->molecule['jmeNumeration'] = trim($row[9]);
        $this->molecule['solvent'] = trim($row[13]);
        $this->molecule['publicCom'] = isset($row[14]) ? trim($row[14]) : '';
        $this->molecule['privateCom'] = isset($row[15]) ? trim($row[15]) : '';
        $this->molecule['nRow']=$this->nRow;
        //Se guarda el primer carbono
        $this->newCarbon($row);
    }

    /*
     * Hace un comprobación para comprobar si es necesario usar los valores por defecto.
     */
    public function checkDefault()
    {
        // CORRECCIÓN: Asegurar que default existe
        if (!isset($this->default)) {
            $this->default = [
                'family' => '',
                'subFamily' => '',
                'subSubFamily' => ''
            ];
        }
        
        if (empty($this->molecule['family'])) {
            $this->molecule['family'] = $this->default['family'] ?? '';
            if (empty($this->molecule['subFamily'])) {
                $this->molecule['subFamily'] = $this->default['subFamily'] ?? '';
                if (empty($this->molecule['subSubFamily'])) {
                    $this->molecule['subSubFamily'] = $this->default['subSubFamily'] ?? '';
                }
            }
        }
    }

    /**
     * Crea una carbono nuevo.
     * @param $row Array que representa la fila del excel que contiene los datos del carbono.
     */
    public
    function newCarbon($row)
    {
        $acceptedValues = array('C', 'CH', 'CH2', 'CH3', "");
        $carbon = array();
        $carbon['id'] = "";
        $carbon['carbonType'] = trim(strtoupper($row[11]));
        $carbon['shift'] = (str_replace(",", ".", trim($row[12])));
        $carbon['numeration'] = trim($row[10]);
        $carbon['num2'] = "";
        if (in_array($carbon['carbonType'], $acceptedValues)) {
            $this->molecule['carbons'][] = $carbon;
        } else {
            Log::info("heteroatomo encontrado");
        }

    }

    /**
     * Recoge el excel, lee el contenido de la primera hoja, y transforma los datos en un array, lo que facilita el manejo.
     */
    public
    function readExcel($request)
    {
        $path = $path = base_path() . DIRECTORY_SEPARATOR . "ExcelFiles" . DIRECTORY_SEPARATOR;
        $file = $request->file('file');

        // Si existe la interfaz de v3, usarla; si no, caer a v2.
        if (interface_exists(\Maatwebsite\Excel\Concerns\ToArray::class)) {
            $allSheets = Excel::toArray(new SheetToArrayImport(), $file);
            $firstSheet = isset($allSheets[0]) ? $allSheets[0] : [];
            $this->excel = array_values($firstSheet);
        } else {
            Excel::selectSheetsByIndex(0)->load($file, function ($reader) {
                $this->excel = array_values($reader->toArray());
            });
        }

        $file->move($path, $file->getClientOriginalName());

        $this->log['operacion'] = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) ." ". date('d-m-Y_H-i-s');
    }

    /**
     * Esta función carga los valores de la linea "especial".
     * Esta línea contiene los datos sobre el autor y los valores por defecto de los compuestos.
     */
    public
    function loadSpecial($row)
    {
        //Se cargan los datos por defecto en caso de que existan
        $this->default['state'] = (!empty($row[1])) ? trim($row[1]) : "";
        $this->default['family'] = (!empty($row[4])) ? trim($row[4]) : "";
        $this->default['subFamily'] = (!empty($row[5])) ? trim($row[5]) : "";
        $this->default['subSubFamily'] = (!empty($row[6])) ? trim($row[6]) : "";
        //Datos del autor
        $this->author = array();
        $this->author['author'] = (!empty($row[12])) ? trim($row[12]) : "";
        $this->author['email'] = (!empty($row[13])) ? trim($row[13]) : "";
        $this->author['organization'] = (!empty($row[14])) ? trim($row[14]) : "";
        $this->author['country'] = (!empty($row[15])) ? trim($row[15]) : "";
    }
}