<?php

namespace App\Http\Controllers;

use App\Carbon;
use App\Http\Requests;
use App\Molecule;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Query\Expression;

class ResultsController extends Controller
{
    public $almacen=array();
    public $contador=0;

    public function get($index = null){

        if($index != null){
            // Convertir a integer y validar
            $index = (int) $index;
            
            if($index <= 0) {
                return redirect('/')->with('error', 'Invalid search index');
            }

            set_time_limit(3000);
            $history = Session::get('history');

            // Validar que existe el historial
            if(!$history || !is_array($history) || count($history) == 0) {
                return redirect('/')->with('error', 'No search history found. Please perform a search first.');
            }

            $arrayIndex = $index - 1;
            
            if(!isset($history[$arrayIndex])) {
                return redirect('/')->with('error', 'Search result not found in history');
            }

            $historyIndex = $history[$arrayIndex];


        $result = $this->queryMoleculas($historyIndex);
        //dd($result);

        //Si hay datos relativos a una busqueda iterativa los actualizamos
        if (isset($result['conditions'])) {
            $history[$arrayIndex]['criteria']['conditions'] = strval($result['conditions']);
        }
        $data['allmol']=$result['allmol'];
        $data['molecules'] = $result['molecules'];
        $data['count'] = $result['count'];

        if(isset($result['select'])){
            $data['select'] = $result['select'];
        }


        //Con esto actualizamos el numero de resultados
        if($result['count']!=0 || $history[$arrayIndex]['count']!=0){
            $history[$arrayIndex]['count'] = $result['count'];
        }

        $history[$arrayIndex]['whereRaw'] = $result['whereRaw'];
        $history[$arrayIndex]['whereBindings'] = $result['whereBindings'];

        if(!isset($history[$arrayIndex]['selected'])){
            $history[$arrayIndex]['selected'] = null;
        }
        // Acumular selección entre páginas en la vista de búsqueda
        $delimitador = ',';
        $existingSelected = isset($history[$arrayIndex]['selected']) ? $history[$arrayIndex]['selected'] : '';
        $newSelected = request()->has('selectedMols') ? request()->get('selectedMols') : '';
        $sessionSelected = Session::get('selectedMols_results', '');

        $existingArr = ($existingSelected !== null && $existingSelected !== '') ? explode($delimitador, $existingSelected) : array();
        $newArr = ($newSelected !== null && $newSelected !== '') ? explode($delimitador, $newSelected) : array();
        $sessionArr = ($sessionSelected !== null && $sessionSelected !== '') ? explode($delimitador, $sessionSelected) : array();

        $merged = array_values(array_unique(array_filter(array_merge($existingArr, $newArr, $sessionArr))));
        $history[$arrayIndex]['selected'] = implode($delimitador, $merged);
        Session::put('selectedMols_results', $history[$arrayIndex]['selected']);
        


        Session::put('history', $history);
       
        Session::put('result', json_encode($result['allmol']));

        /** si existe el select, entonces se ha realizado una busqueda por desplazamiento
         * se realizan los calculos necesarios */
        if(isset($data['select'])){

            $datos= array();
            $desplazamientos= Array();
            $numeracion= array();
            $historialConsulta = null;

            /***calculos con el history para sacar cual es el valor del desplazamiento buscado**/

            // Para las busquedas simples por desplazamiento
            if ($history[$arrayIndex]["type"] == "byShiftNoPosition") {
                $historialConsulta=$history[$arrayIndex]['criteria']['shiftsArray']; //almacena los datos de la ultima busqueda

            // Para las busquedas combinadas, buscamos todos los posibles shiftsArray y los combinamos
            } else {
                $historialConsulta = [];
                foreach ($history[$arrayIndex]['criteria'] as $key => $value) {
                    if (is_array($value)) {
                        if (isset($value["shiftsArray"])) {
                            $historialConsulta = array_merge($historialConsulta, $value["shiftsArray"]);
                        }
                    }
                }
                
                // Eliminar duplicados en búsquedas combinadas OR
                if ($history[$arrayIndex]["type"] == "comb") {
                    $originalCount = count($historialConsulta);
                    $historialConsulta = $this->removeDuplicateShiftConditions($historialConsulta);
                    $newCount = count($historialConsulta);
                    // Debug temporal
                    if ($originalCount != $newCount) {
                        \Log::info("Duplicados eliminados: $originalCount -> $newCount");
                    }
                }
            }

            if (empty($historialConsulta)) {
                dd("error");
            }

            for($i=0; $i< sizeof($historialConsulta) ; $i++){

                $historialConsulta[$i]['shift'] = ($historialConsulta[$i]['shiftMax'] - ($historialConsulta[$i]['shiftMax'] - $historialConsulta[$i]['shiftMin']) / 2);

            }

            /**recorre el array de moleculas comparandolo con los datos guardados en el almacen, que es donde se
             * guardan los resultados de la busqueda*/
            // echo "*<pre>";
            // print_r("Fuera");
            // echo "</pre>*";
            // echo "*<pre>";
            // print_r($this->almacen);
            // echo "</pre>*";
            //$vueltas = 0;

            for( $i = 0 ; $i < sizeof( $data[ 'molecules' ] ) ; $i++){
                // echo "*<pre>";
                // print_r("Bucle 1");
                // echo "</pre>*";
                for( $j = 0 ; $j < sizeof( $this->almacen ) ; $j++){
                    // echo "*<pre>";
                    // print_r("Bucle 2");
                    // echo "</pre>*";

                    // echo "*J<pre>";
                    // print_r($j);
                    // echo "</pre>*";

                    for( $h = 0 ; $h < sizeof( $this->almacen[$j] ) ; $h++){
                        $level = $this->almacen[$j][$h]->level;

                        if( $data['molecules'][$i]->id  == $this->almacen[$j][$h]->molecularId ){
                        // echo "*<pre>";
                        // print_r($this->almacen[$j][$h]);
                        // echo "</pre>*";

                            // $contador = $j - (count($historialConsulta) * $vueltas) + $vueltas;
                            // if ($contador >= count($historialConsulta)) {
                            //     $contador = $contador - count($historialConsulta);
                            // }

                            // echo "<table class='table table-bordered'><tr><td width='100px'>j</td><td width='100px'>vueltas</td><td width='100px'>contador</td><td width='100px'>almacen</td><td width='100px'>level</td><td width='100px'>historial</td><td width='100px'>DESPLAZAMIENTO</td></tr>";
                            // echo "<tr><td>" . $j . "</td><td>" . $vueltas . "</td><td>" . $contador . "</td><td>" . $this->almacen[$j][$h]->shift . "</td><td>" . $this->almacen[$j][$h]->level . "</td><td>" . $historialConsulta[$contador]['shift'] . "</td><td>" . (round(abs($this->almacen[$j][$h]->shift - $historialConsulta[$contador]['shift']))) . "</td></tr></table>";

                            // if (!isset($historialConsulta[$j])) {
                            //     continue;
                            // }


                            $datos[ $data['molecules'][$i]->id ][] = Carbon::indices( $this->almacen[$j][$h]->molecularId, $this->almacen[$j][$h]->num2);
                            /**se guardan en esa posicion del array para estar en la misma que las de $datos y ser mas
                             * facil luego manipular los daatos**/
                            $desplazamientos[ $data['molecules'][$i]->id ][]=round(abs($this->almacen[$j][$h]->shift - $historialConsulta[$level]['shift']));
                            $numeracion[ $data['molecules'][$i]->id ][]=$this->almacen[$j][$h]->num2;
                        }
                    }

                    // if (($j+1) % (count($historialConsulta) - $level) == 0) {
                        // echo "*<pre>";
                        // print_r("FIN DE VUELTA");
                        // echo "</pre>*";
                        // $vueltas++;
                    // }

                }
            }

            $data['histoConsulta']=$historialConsulta;
            $data['datos']=$datos;
            $data['desplazamientos']=$desplazamientos;
            $data['numeracion']=$numeracion;

        }


        //mover $data['molecules'] fnciona para cambiar el orden, pero eso sirve para poco

        //dd($data['datos']);
        //dd($data);

        }

        //dd($data);

        $this->contador=0;
        return view('search.results', $data)
                    ->with('history', Session::get('history'))
                    ->with('data',$data)
                    ->with('index', $index);
    }


    /**
     * Realiza la consulta y devuelve el resultado
     * @param $historyIndex
     * @return null
     * @internal param $criteria
     * @internal param $historyIndex
     */
    public function queryMoleculas($historyIndex) {
        //Si el elemento del historial tiene ya una consulta guardada pasa por aqui
        if(isset($historyIndex['whereRaw']) && isset($historyIndex['whereBindings'])) {
            return $this->historyQuery($historyIndex['whereRaw'], $historyIndex['whereBindings'], $historyIndex['criteria']);
        }
        //Los elementos de historial que provengan de un buscador pasan siempre por aqui la primera vez
        else {
            return $this->basicQuery($historyIndex['criteria']);
        }
    }

    /**
     * Metodo que realiza las busquedas
     * @param $criteria
     * @return mixed
     */
    public function basicQuery($criteria) {
        $webServiceData = array();

        //Empezamos a montar la consulta
        $molecules = Molecule::select('molecules.id', 'jme', 'jmeNumeration', 'jmeDisplacement', 'smiles', 'reference', 'family' , 'subFamily' , 'subSubFamily' , 'solvent', 'bibliographies.doi');
        // JOIN con bibliographies desde el inicio
        $molecules->join('bibliographies', 'molecules.bibliography', '=', 'bibliographies.id');

        //Si la familia no esta vacia
        if (!empty($criteria['family'])) {
            $molecules->where('family', $criteria['family']);
            $webServiceData[] = $criteria['family'];
        }
        else {
            $webServiceData[] = "";
        }
        //Si la subfamilia no esta vacia
        if (!empty($criteria['subFamily'])) {
            $molecules->where('subFamily', $criteria['subFamily']);
            $webServiceData[] = $criteria['subFamily'];
        } else {
            $webServiceData[] = "";
        }
        //Si la subSubFamilia no esta vacia
        if (!empty($criteria['subSubFamily'])) {
            $molecules->where('subSubFamily', $criteria['subSubFamily']);
            $webServiceData[] = $criteria['subSubFamily'];
        } else {
            $webServiceData[] = "";
        }
        //Añadimos la formula a la consulta
        if (!empty($criteria['molecularFormula'])) {
            $molecules->where('molecularFormula', 'rlike', $criteria['molecularFormula']);
        }
        //Si tenemos un minimo en el peso molecular pero no un maximo
        if (!empty($criteria['minWeight']) && empty($criteria['maxWeight'])) {
            $molecules->where('molecularWeight', '>', $criteria['minWeight']);
        } //Si tenemos un maximo en el peso pero no un minimo
        else if (empty($criteria['minWeight']) && !empty($criteria['maxWeight'])) {
            $molecules->where('molecularWeight', '<', $criteria['maxWeight']);
        } //Si tenemos los dos
        else if (!empty($criteria['minWeight']) && !empty($criteria['maxWeight'])) {
            $molecules->whereBetween('molecularWeight', [$criteria['minWeight'], $criteria['maxWeight']]);
        }
        //Nombre trivial
        if (!empty($criteria['triName'])) {
            $molecules->where('name', 'like', '%' . $criteria['triName'] . '%');
        }
        //Nombre semisistematico
        if (!empty($criteria['semiName'])) {
            $molecules->where('semiSystematicName', 'like', '%' . $criteria['semiName'] . '%');
        }
        //Si existen datos relativos a la bibliografia
        if (!empty($criteria['authors']) || !empty($criteria['magazine']) || !empty($criteria['year']) || !empty($criteria['volume']) || !empty($criteria['page'])) {
            //Bibliografia
            // JOIN ya está arriba, no duplicar
            // $molecules->join('bibliographies', 'molecules.bibliography', '=', 'bibliographies.id');
            //Autores
            if (!empty($criteria['authors'])) {
                $molecules->where('bibliographies.authors', 'like', '%' . $criteria['authors'] . '%');
            }
            //Revista
            if (!empty($criteria['magazine'])) {
                $molecules->where('bibliographies.magazine', 'like', '%' . $criteria['magazine'] . '%');
            }
            //Año
            if (!empty($criteria['year'])) {
                $molecules->where('bibliographies.year', $criteria['year']);
            }
            //Volumen
            if (!empty($criteria['volume'])) {
                $molecules->where('bibliographies.volume', $criteria['volume']);
            }
            //Pagina

            if (!empty($criteria['page'])) {
                //->orWhere('bibliographies.page', 'rlike', '^'.$criteria['page'].'\D*-[0-9]*$');
                //where('bibliographies.page', $criteria['page'])
                //$molecules->where('bibliographies.page', 'rlike', '^'.$criteria['page'].'\D*-[0-9]*$')
                //          ->orWhere('bibliographies.page', $criteria['page']);


                $molecules->where(function($query) use ($criteria) {
                    $page = preg_split("/-|–/", $criteria['page']);
                    $page = implode("[-–]", $page);

                    $query->where('bibliographies.page', 'rlike', '^'.$page.'(\D*[-–][0-9]*)?$');
                    $query->orWhere('bibliographies.page', $criteria['page']);
                });
            }

        }


        if (!empty($criteria['smileCode'])) {
            $molecules->whereRaw('`smileCode` = '.'`'.$criteria['smileCode'].'`');
        }
        if(!empty($criteria['minCarbons'])) {
            $molecules->whereRaw('`minCarbons` = '.'`'.$criteria['minCarbons'].'`'); 
        }
      if(!empty($criteria['shiftsArray'])) {
    $molecules->whereIn('molecules.id', function($query) use ($criteria) {
        $query->from('carbonTypes')->select('molecularId');
        if (!empty($criteria['carbonTypes'])) {
            foreach($criteria['carbonTypes'] as $carbonType) {
                $query->whereBetween($carbonType['label'], [$carbonType['min'], $carbonType['max']]);
            }
        }
    });
}
        //Nos quedamos con el where
        $query = $molecules->toSql();

        //dd($query);

        preg_match_all("/(where.*)/" , $query ,$matches);

        //Esta comprobacion solo esta por si acaso
        if(sizeof($matches[0]) == 0)
            $query = "molecules.id < 0";
        else
            $query = "(".$matches[0][0].")";
        $query = preg_replace('/(where)/ ','',$query, 1);
        //dd($query);
        //Guardamos la sentencia con sus datos
        $result['whereRaw'] = $query;
        $result['whereBindings'] = $molecules->getBindings();

        //Reemplazamos los smiles en caso de que existan
        $query = $this->replaceSmiles($query, $webServiceData);
        //dd($query);
        $data = $this->replaceShiftData($query);
        $query = $data['query'];

       //dd($query);

        //Si existen datos de la busqueda iterativa
        if(isset($data['conditions'])){
            $result['conditions'] = $data['conditions'];
        }

        //Realizamos la busqueda
        $molecules = Molecule::select('molecules.id', 'jme', 'jmeNumeration', 'jmeDisplacement', 'smiles', 'reference', 'family' , 'subFamily', 'subSubFamily', 'solvent', 'bibliographies.doi');
        $molecules->join('bibliographies', 'molecules.bibliography', '=', 'bibliographies.id');
        //Filtramos las que no tienen estado 6
        $molecules->whereBetween('state', ['1', '4']);
        $molecules->where('deleted_at', null);
        $molecules->whereRaw($query, $result['whereBindings'])->remember(config('rememberTime.time'));

        // Modo seleccionado: si selectedMode=1 y no hay IDs, devolvemos 0 resultados
        if (request()->get('selectedMode') === '1') {
            $idsParam = request()->get('selectedMols', '');
            $ids = array_values(array_filter(explode(',', $idsParam)));
            if (empty($ids)) {
                $molecules->whereRaw('1 = 0');
            } else {
                $molecules->whereIn('molecules.id', $ids);
            }
        }

        

        /*ordena por desplazamiento*/
        if (isset($data['strIds'])) {
            // $molecules->orderBy(DB::raw('FIND_IN_SET(molecules.id, "'.$data['strIds'].'")'), 'ASC');
            $molecules->orderBy('molecules.reference', 'ASC');
        }


        $result['allmol']=$molecules->paginate(30000); // esto no parece hacer nada
        $result['count'] = $result['allmol']->total();
        $pageSize = request()->get('selectedMode') === '1' ? 30000 : 6;
        $result['molecules'] = $molecules->paginate($pageSize);

        if(isset($data['select'])){
            $result['select'] = $data['select'];
        }
        //dd($result);
        return $result;
    }


    /**
     * Ejecuta una busqueda con los datos de un elemento del historial
     * @param $whereRaw
     * @param $whereBindings
     * @param $criteria
     * @return mixed
     */
    public function historyQuery($whereRaw, $whereBindings, $criteria) {

        // dd($whereRaw, $whereBindings, $criteria);

        $webServiceData = array();
        if (!empty($criteria['family'])) {
            $webServiceData[] = $criteria['family'];
        }
        else {
            $webServiceData[] = "";
        }
        //Si la subfamilia no esta vacia
        if (!empty($criteria['subsubFamily'])) {
            $webServiceData[] = $criteria['subFamily'];
        } else {
            $webServiceData[] = "";
        }
        //Si la subSubFamilia no esta vacia
        if (!empty($criteria['subSubFamily'])) {
            $webServiceData[] = $criteria['subSubFamily'];
        } else {
            $webServiceData[] = "";
        }
        $result['whereRaw'] = $whereRaw;
        $result['whereBindings'] = $whereBindings;
        $whereRaw = $this->replaceSmiles($whereRaw, $webServiceData);
        $data = $this->replaceShiftData($whereRaw);

        $whereRaw = $data['query'];
        $molecules = Molecule::select('molecules.id', 'jme', 'jmeNumeration', 'jmeDisplacement', 'smiles', 'reference', 'family', 'subFamily' , 'subSubFamily', 'solvent', 'bibliographies.doi');
        $molecules->join('bibliographies', 'molecules.bibliography', '=', 'bibliographies.id');
        //Filtramos las que no tienen estado 6
        $molecules->whereBetween('state', ['1', '4']);
        $molecules->where('deleted_at', null);
        $molecules->whereRaw($whereRaw, $whereBindings)->remember(config('rememberTime.time'));

        // Modo seleccionado: si selectedMode=1 y no hay IDs, devolvemos 0 resultados
        if (request()->get('selectedMode') === '1') {
            $idsParam = request()->get('selectedMols', '');
            $ids = array_values(array_filter(explode(',', $idsParam)));
            if (empty($ids)) {
                $molecules->whereRaw('1 = 0');
            } else {
                $molecules->whereIn('molecules.id', $ids);
            }
        }

        /*ordenacion por desplazamiento*///no
        if (isset($data['strIds'])) {
            // $molecules->orderBy(DB::raw('FIND_IN_SET(molecules.id, "'.$data['strIds'].'")'), 'ASC');
            $molecules->orderBy('molecules.reference', 'ASC');
        }
        $result['allmol']= $molecules->paginate(30000);
        $result['count'] = $result['allmol']->total();
        $pageSize = request()->get('selectedMode') === '1' ? 30000 : 6;
        $result['molecules'] = $molecules->paginate($pageSize);

        if(isset($data['select'])){
            $result['select'] = $data['select']; //arrastramos el resultado de la consulta//
        }

        return $result;
    }

    /**
     * Devuelve las ids de las moleculas con esta subestructura
     * @param $smiles
     * @param $webServiceData
     * @return mixed
     */
    public function getIdsFromSmiles($smiles, $webServiceData) {
        $webServiceData[] = $smiles;

    //LLamada a la api web, devuelve las id de las moleculas que complen las condiciones
    // $uri=config('c13javaWebServices.url')."SubstructureChecker?json=" . json_encode($webServiceData);

  // Funcionando tomcat 9 materiamedica.net
  $uri=config('c13javaWebServices.url')."SubstructureChecker?json=" . urlencode(json_encode($webServiceData));
        // echo "*<pre>";
        // print_r($uri);
        // echo "</pre>*";

        $response[] = \Httpful\Request::get($uri)->send();

        $ids = $response[0]->body;

        // echo "*<pre>";
        // print_r($ids);
        // echo "</pre>*";
        return $ids;
    }

    /**
     * Realiza la busqueda iterativa y devuelve los datos necesarios para el resultado
     * @param $criteria
     * @return array|mixed
     */
    public function byShiftQuery($criteria) {

        $resultsArray = array();
        $num = count($criteria['shiftsArray']);
        $minCarbons = $criteria['minCarbons'];

        //El numero total de combinaciones
        $total = pow(2, $num);

        //Genera todas las posibles combinaciones
        for ($i = 0; $i < $total; $i++) {
            //For each combination check if each bit is set
            for ($j = 0; $j < $num; $j++) {
                //Is bit $j set in $i?
                if (pow(2, $j) & $i) {
                    $criteria['shiftsArray'][$j]['level'] = $j;
                    $resultsArray[$i][] = $criteria['shiftsArray'][$j];
                }
            }
        }

        sort($resultsArray);
        $resultsArray = array_reverse($resultsArray); //Array con todas las combinaciones de busqueda

        // echo "*<pre>";
        // print_r($resultsArray);
        // echo "</pre>*";

        $minLevel = sizeof($resultsArray[0]) - ($minCarbons - 1);

        $moleculesId = array();

        for($i = 0; $i < sizeof($resultsArray) && sizeof($resultsArray[$i]) >= $minLevel; $i++) {
            // Normalizamos el orden de las condiciones para que el resultado sea independiente del orden de entrada
            $resultsArray[$i] = $this->sortSearchConditions($resultsArray[$i]);
            // Eliminado el corte temprano: debemos considerar todas las combinaciones
            // de tamaño >= minLevel para que el resultado sea independiente del orden
            // de entrada y no perdamos compuestos válidos.
            //Si el tamaño es menor que el del array original, se repiten tipos de carbono
            $flag1 = sizeof(array_unique(Arr::pluck($resultsArray[$i], 'carbonType'))) < sizeof($resultsArray[$i]);

            if($flag1) { //Si se repiten los tipos de carbono
                //Comprobamos si se superponen en desplazamiento
                $flag2 = $this->getOverlap($resultsArray[$i]);

                if($flag2){ //Si se superponen hacemos busqueda compleja
                    // echo "<pre>";
                    // echo "lo llamo desde fuera<br />";
                    $result = $this->queryCarbonsIterative($resultsArray[$i]);
                    // echo "</pre>";
                    // dd("fin");
                }
                else{
                    $result = $this->queryCarbonsNormal($resultsArray[$i]);
                }
            }
            else{ //Si no se repiten se puede hacer una busqueda mas sencilla
                $result = $this->queryCarbonsNormal($resultsArray[$i]);
            }
            // Unimos (OR) los ids para evitar dependencia del orden de entrada
            $moleculesId = array_unique(array_merge($moleculesId, $result['ids']));
        }

        /**Arrastramos el query/resultado_del_query hasta el result para devolverlo a replaceShiftData**/
        $result = [
            'moleculesId' => $moleculesId,
            'conditions' => sizeof($resultsArray[$i-1]),
            'select' => $result['select'],
        ];

        return $result;
    }

    /**
     * Devuelve el resultado para una combinacion de la busqueda iterativa
     * @param $data
     * @param array $ids
     * @param array $carbonsIds
     * @param int $globalIndex
     * @return mixed
     */
    public function queryCarbonsIterative($data, $ids = array(), $carbonsIds = array(), $globalIndex = 0, $result = []) {

        // Si $data es una lista de condiciones, la ordenamos de forma determinista por el centro del rango
        $data = $this->sortSearchConditions($data);

        // Si es la primera iretacion de la recursividad
        // se inicializa el array
        // En caso contrario no, para ir mandando el acumulado
        if (empty($result)) {
            $result = [
                'ids' => [],
                'carbonsIds' => [],
                'select' => [],
            ];
        }

        // echo "*<pre>";
        // print_r($data);
        // echo "</pre>*";

        foreach($data as $index => $value){
            if(is_numeric($index) && is_array($value)) {
                // echo "<br /><br /><strong>Entro por el if </strong><br />";
                // echo "&nbsp;&nbsp;Data ".json_encode($data)."<br />";
                // echo "&nbsp;&nbsp;index ".json_encode($index)."<br />";
                // echo "&nbsp;&nbsp;value ".json_encode($value)."<br />";
                // echo "&nbsp;&nbsp;ids ".json_encode($ids)."<br />";
                // echo "&nbsp;&nbsp;carbonsIds ".json_encode($carbonsIds)."<br />";
                // echo "&nbsp;&nbsp;globalIndex ".json_encode($globalIndex)."<br />";
                // echo "&nbsp;&nbsp;Entro en la recursividad<br />";

                $resultrecursive = $this->queryCarbonsIterative($value, $ids, $carbonsIds, $index, $result);
                // echo "&nbsp;&nbsp;Volvemos de la recursividad con este resultado<br />";
                // echo "&nbsp;&nbsp;Result".json_encode($resultrecursive)."<br />";

                // $result['ids'] = array_merge($result['ids'], $resultrecursive['ids']);
                // $result['carbonsIds'] = array_merge($result['carbonsIds'], $resultrecursive['carbonsIds']);
                // $result['select'] = array_merge($result['select'], $resultrecursive['select']);

                $result['ids'] = $resultrecursive['ids'];
                $result['carbonsIds'] = $resultrecursive['carbonsIds'];
                $result['select']= $resultrecursive['select'];

                $ids = $result['ids'];
                $carbonsIds = $result['carbonsIds'];
            }
            else {


                $carbonType = [$data['carbonType']];
                if ($data['carbonType'] == 'unknown') {
                    $carbonType = ['C', 'CH', 'CH2', 'CH3'];
                }
                if ($data['carbonType'] == 'e') {
                    $carbonType = ['CH', 'CH3'];
                }

                $level = $data['level'];
                // Subconsulta: mínimo id por molecularId bajo los mismos filtros
                $sub = Carbon::select(DB::raw('molecularId, MIN(id) AS id'))
                    ->whereIn('carbonType', $carbonType)
                    ->whereBetween('shift', [$data['shiftMin'], $data['shiftMax']])
                    ->whereNotIn('id', $carbonsIds)
                    ->groupBy('molecularId');
                $subSql = $sub->toSql();
                $subBindings = $sub->getBindings();

                // Unimos la subconsulta para traer la fila completa correspondiente a ese MIN(id)
                $carbons = Carbon::from('carbons as c')
                    ->join(DB::raw('(' . $subSql . ') as t'), function ($join) {
                        $join->on('t.molecularId', '=', 'c.molecularId')
                             ->on('t.id', '=', 'c.id');
                    })
                    ->select(
                        'c.id',
                        'c.molecularId',
                        'c.num2',
                        'c.numeration',
                        'c.carbonType',
                        'c.shift',
                        DB::raw("'$level' as level")
                    )
                    ->remember(config('rememberTime.time'));
                // Añadimos los bindings de la subconsulta al contexto del join
                $carbons->addBinding($subBindings, 'join');

                if ($globalIndex !== 0) {
                    $carbons->whereIn('c.molecularId', $result['ids']);
                }

                // CORRECCIÓN: Usar get() en lugar de toSql() para evitar problemas con Expression en bindings
                $select = $carbons->get()->toArray();
                
                // Convertir a objetos stdClass para mantener compatibilidad con el código existente
                $select = json_decode(json_encode($select));



                $auxCarbons = Arr::pluck($select, 'id');
                $auxMoleculeIds = array_unique(Arr::pluck($select, 'molecularId'));



                $ids = (sizeof($ids) == 0 && $globalIndex == 0)? $auxMoleculeIds : array_unique(array_intersect($ids, $auxMoleculeIds));



                //Ordenamos los carbonos y los filtramos para obtener solo los que queremos
                $shiftValue = ($data['shiftMax'] - ($data['shiftMax'] - $data['shiftMin']) / 2);
                
                // Nueva consulta ordenada
                $carbonsOrdered = Carbon::from('carbons as c')
                    ->join(DB::raw('(' . $subSql . ') as t'), function ($join) {
                        $join->on('t.molecularId', '=', 'c.molecularId')
                             ->on('t.id', '=', 'c.id');
                    })
                    ->select(
                        'c.id',
                        'c.molecularId',
                        'c.num2',
                        'c.numeration',
                        'c.carbonType',
                        'c.shift',
                        DB::raw("'$level' as level")
                    )
                    ->whereIn('c.molecularId', $ids)
                    ->orderBy(DB::raw('ABS(c.shift - '.$shiftValue.')'), 'ASC')
                    ->remember(config('rememberTime.time'));
                $carbonsOrdered->addBinding($subBindings, 'join');
                
                // CORRECCIÓN: Usar get() en lugar de cacheQuery con toSql()
                $select = $carbonsOrdered->get()->toArray();
                $select = json_decode(json_encode($select));

                // echo "*<pre>";
                // print_r($shiftValue);
                // echo "</pre>*";

                //dd($select);
                // echo "select despues ".json_encode($select)."<br />";

                $ids = array_unique(Arr::pluck($select, 'molecularId'));
                $carbonsIds = (sizeof($carbonsIds) == 0 && $globalIndex == 0)? $auxCarbons : array_unique(array_merge($carbonsIds, $auxCarbons));

                // if ($globalIndex == 0) {
                //     echo "Desde el else Vuelta " . $globalIndex . ", guardamos todo<br />";

                //     $result['ids'] = $ids;
                //     $result['carbonsIds'] = $carbonsIds;
                //     $result['select']= $select;
                // } else {

                //     echo "Desde el else Vuelta " . $globalIndex . ", interseccionamos<br />";

                //     $result['ids'] = array_intersect($result['ids'] ?? [], $ids);
                //     $result['carbonsIds'] = array_intersect($result['carbonsIds'] ?? [], $carbonsIds);
                //     $result['select']= array_merge($result['select'] ?? [], $select);
                // }

                $result['ids'] = $ids;
                $result['carbonsIds'] = $carbonsIds;
                $result['select']= $select;


                $this->almacen[$this->contador]=$select;
                $this->contador++;

                // $result['select']=[
                //     [
                //         "id" => 653541,
                //         "molecularId" => 24520,
                //         "num2" => 2,
                //         "numeration" => "2",
                //         "carbonType" => "CH",
                //         "shift" => 324.0,
                //     ]
                // ];
                break;
            }

            // echo "fin de vuelta<br /><br />";

        }
        // echo "Devuelve Result".json_encode($result)."<br /><br />";

        return $result;
    }

    public function queryCarbonsIterativeViejo($data, $ids = array(), $carbonsIds = array(), $globalIndex = 0) {
        foreach($data as $index => $value){
            if(is_numeric($index) && is_array($value)) {
                $result = $this->queryCarbonsIterative($value, $ids, $carbonsIds, $index);
                $ids = $result['ids'];
                $carbonsIds = $result['carbonsIds'];
            }
            else {
                $carbons = Carbon::select(DB::raw('MIN(carbons.id) as id'),'molecularId')
                    ->where('carbonType', $data['carbonType'])
                    ->whereBetween('shift', [$data['shiftMin'], $data['shiftMax']])
                    ->whereNotIn('carbons.id', $carbonsIds)
                    ->groupBy('molecularId')
                    ->remember(config('rememberTime.time'));

                $query = $carbons->toSql();

                $bindings = $carbons->getBindings();
                $select = $this->cacheQuery($query, $bindings);


                $auxCarbons = Arr::pluck($select, 'carbons.id');
                $auxIds = array_unique(Arr::pluck($select, 'molecularId'));

                $ids = (sizeof($ids) == 0 && $globalIndex == 0)? $auxIds : array_unique(array_intersect($ids, array_unique($auxIds)));

                //Ordenamos los carbonos y los filtramos para obtener solo los que queremos
                $shiftValue = ($data['shiftMax'] - ($data['shiftMax'] - $data['shiftMin']) / 2);
                $carbons->whereIn('molecularId', $ids)
                    ->orderBy(DB::raw('ABS(shift - '.$shiftValue.')'), 'ASC')
                    ->remember(config('rememberTime.time'));

                $query = $carbons->toSql();
                $bindings = $carbons->getBindings();
                $select = $this->cacheQuery($query, $bindings);

                //dd($select);

                $ids = array_unique(Arr::pluck($select, 'molecularId'));
                $carbonsIds = (sizeof($carbonsIds) == 0 && $globalIndex == 0)? $auxCarbons : array_unique(array_merge($carbonsIds, $auxCarbons));

                $result['ids'] = $ids;
                $result['carbonsIds'] = $carbonsIds;
                $result['select']= $select;
                break;
            }
        }

        return $result;
    }

    /**
     * BUSQUEDA POR SHIFT
     *
     * Devuelve el resultado para una combinacion de la busqueda iterativa en la que no es necesario comprobar carbonos repetidos
     * @param $data
     * @param array $ids
     * @param int $globalIndex
     * @return mixed
     */
    public function queryCarbonsNormal($data, $ids = array(), $globalIndex = 0) {
        // Aseguramos que $data sea una lista de condiciones. Si viene una sola condición, la envolvemos.
        if (isset($data['shiftMin']) && isset($data['shiftMax'])) {
            $data = [$data];
        }

        // Orden estable por centro del rango para independencia del orden de entrada
        $data = $this->sortSearchConditions($data);

        $currentIds = [];
        $first = true;
        $allSelect = [];

        foreach ($data as $condIdx => $cond) {
            $carbonType = [$cond['carbonType']];
            if ($cond['carbonType'] == 'unknown') {
                $carbonType = ['C', 'CH', 'CH2', 'CH3'];
            }
            if ($cond['carbonType'] == 'e') {
                $carbonType = ['CH', 'CH3'];
            }

            $level = isset($cond['level']) ? $cond['level'] : $condIdx;
            $carbons = Carbon::select('carbons.id','molecularId','num2','numeration','carbonType','shift', DB::raw("'$level' as level"))
                ->whereIn('carbonType', $carbonType)
                ->whereBetween('shift', [$cond['shiftMin'], $cond['shiftMax']])
                ->remember(config('rememberTime.time'));

            // CORRECCIÓN: Usar get() en lugar de toSql() + cacheQuery
            $select = $carbons->get()->toArray();
            $select = json_decode(json_encode($select));

            $allSelect = array_merge($allSelect, $select);
            $idsForCond = array_unique(Arr::pluck($select, 'molecularId'));

            if ($first) {
                $currentIds = $idsForCond;
                $first = false;
            } else {
                // Intersección: deben cumplirse todas las condiciones del conjunto
                $currentIds = array_values(array_unique(array_intersect($currentIds, $idsForCond)));
            }
        }

        $result['ids'] = array_values($currentIds);
        $result['select'] = $allSelect;

        // Guardamos en almacén para posteriores cálculos
        $this->almacen[$this->contador] = $allSelect;
        $this->contador++;

        return $result;
    }

    /**
     * Ordena condiciones de búsqueda por el centro del rango de desplazamiento (ascendente) y, de
     * forma secundaria, por carbonType. Si no es una lista de condiciones, devuelve el dato intacto.
     */
    private function sortSearchConditions($data) {
        if (!is_array($data)) { return $data; }
        // Detecta si es una lista indexada 0..n de condiciones con claves shiftMin/shiftMax
        $isList = array_keys($data) === range(0, count($data) - 1);
        if (!$isList) { return $data; }
        $allAreConds = true;
        foreach ($data as $elem) {
            if (!is_array($elem) || !isset($elem['shiftMin']) || !isset($elem['shiftMax'])) { $allAreConds = false; break; }
        }
        if (!$allAreConds) { return $data; }
        usort($data, function($a, $b) {
            $centerA = $a['shiftMax'] - ($a['shiftMax'] - $a['shiftMin']) / 2;
            $centerB = $b['shiftMax'] - ($b['shiftMax'] - $b['shiftMin']) / 2;
            if ($centerA == $centerB) {
                return strcmp(strval($a['carbonType']), strval($b['carbonType']));
            }
            return ($centerA < $centerB) ? -1 : 1;
        });
        return $data;
    }

    /**
     * Comprueba si hay superposicion de desplazamientos y devuelve true o false
     * @param $data
     * @return bool
     */
    public function getOverlap($data) {

        $shifts = array();
        foreach($data as $index => $value) {
            $range = range(($value['shiftMin']), $value['shiftMax']);

            // Convierto a string para que no falle la funcion array_count_values
            for ($i=0; $i < count($range); $i++) {
                $range[$i] = strval($range[$i]);
            }


            if (!isset($shifts[$value['carbonType']])) {
                $shifts[$value['carbonType']] = [];
            }
            $shifts[$value['carbonType']] = array_merge($shifts[$value['carbonType']], $range);
            //$shifts = array_merge($shifts, $range);
        }

        $overlap = false;
        foreach ($shifts as $key => $type) {
            $aux = Arr::where(array_count_values($type), function ($key, $value) {
                return $value > 1;
            });
            if(sizeof($aux) > 0) {
                $overlap = true;
            }
        }

        if($overlap) {
            return true;
        }

        return false;
    }

    /**
     * Reemplaza los smiles de la query por un where in
     * @param $query
     * @param $webServiceData
     * @return mixed
     */
    public function replaceSmiles($query, $webServiceData = array("","","")) {
        //Cogemos todos los smiles
        preg_match_all('/(?<=`smileCode` = `).[^\`]*/', $query, $matches);
        //Si la busqueda contiene codigo smiles es busqueda por subestructura
        if(!empty($matches[0])) {
            foreach($matches[0] as $match) {
                try {
                    $ids = $this->getIdsFromSmiles($match, $webServiceData);
                    //dd($ids);
                }
                catch(Exception $ex) {
                    $ids = array();

                    //dd($ids);
                }

                // dd($ids);
                $strIds = (!is_array($ids) || sizeof($ids) == 0) ? '-9999' : implode(",", $ids);
                $match = str_replace('\\', '\\\\', $match);
                $match = str_replace('/', '\/', $match);
                $match = str_replace('(', '\(', $match);
                $match = str_replace(')', '\)', $match);
                $match = str_replace('[', '\[', $match);
                $match = str_replace(']', '\]', $match);
                $match = str_replace('+', '\+', $match);
                $match = str_replace('*', '\*', $match);
                $query = preg_replace('/(`smileCode` = `'.$match.'`)/','`molecules`.`id` in (' . $strIds . ')', $query, 1);
            }
        }
        return $query;
    }

    /**
     *  BUSQUEDA POR DESPLAZAMIENTO
     * Devuelve los datos con la nueva query y las condiciones que cumplen las moleculas
     * @param $query
     * @return mixed
     */
    public function replaceShiftData($query) {
        $result=null;

        //Volvemos a montar el criterio de busqueda del buscador iterativo
        preg_match_all('/((?<=`minCarbons` = `).[^\`]*)/', $query, $matchesMinCarbons);
        preg_match_all('/((?<=`shiftsArray` = `).[^\`]*)/', $query, $matchesShiftsArray);


        if(!empty($matchesMinCarbons[0]) && !empty($matchesShiftsArray[0])) {
            // Eliminar duplicados antes de procesar
            $uniquePairs = [];
            $processedIndices = [];
            
            for($i = 0; $i < sizeof($matchesShiftsArray[0]); $i++) {
                $minCarbons = $matchesMinCarbons[0][$i];
                $shiftsArray = json_decode($matchesShiftsArray[0][$i], true);
                
                // Crear clave única para detectar duplicados
                $key = $minCarbons . '|' . json_encode($shiftsArray);
                
                if (!in_array($key, $uniquePairs)) {
                    $uniquePairs[] = $key;
                    $processedIndices[] = $i;
                }
            }
            
            // Procesar solo los pares únicos
            foreach($processedIndices as $i) {
                $criteria['minCarbons'] = $matchesMinCarbons[0][$i];
                $criteria['shiftsArray'] = json_decode($matchesShiftsArray[0][$i], true);

                $result = $this->byShiftQuery($criteria);

                $data['conditions'] = $result['conditions'];
                //dd($result['moleculesId']);
                $strIds = (sizeof($result['moleculesId']) == 0) ? '-9999' : implode(",", $result['moleculesId']);
                //Eliminamos lo inncesario
                $query = preg_replace('/(`minCarbons` = `(.+?)` and `shiftsArray` = `\[\{(.+?)\}\]`)/','`molecules`.`id` in (' . $strIds . ')', $query, 1);
            }
        }

        $data['query'] = $query;
        $data['strIds'] = isset($strIds) ? $strIds : '';
        if(isset($result)){
            $data['select'] = $result['select']; //arrastramos el valor para que lo puedan coger en otro lado//
        }

        return $data;
    }

    /**
     * Guarda una raw query en cache
     * @param $sql
     * @param $bindings
     * @return mixed
     */
    public function cacheQuery($sql, $bindings) {
        // CORRECCIÓN: Convertir a string si es Expression
        $sqlString = ($sql instanceof Expression) ? (string) $sql : $sql;
        
        return Cache::remember(md5($sqlString . json_encode($bindings)), config('rememberTime.time'), function() use ($sql, $bindings) {
            // Si $sql ya es un Expression, usarlo directamente
            if ($sql instanceof Expression) {
                return DB::select($sql, $bindings);
            }
            // Si es string, usar DB::raw
            return DB::select(DB::raw($sql), $bindings);
        });
    }

    /**
     * Elimina condiciones de desplazamiento duplicadas en búsquedas combinadas
     * @param array $shiftsArray
     * @return array
     */
    private function removeDuplicateShiftConditions($shiftsArray) {
        $unique = [];
        $seen = [];
        
        foreach ($shiftsArray as $shift) {
            // Crear una clave única basada en las propiedades de la condición
            $key = $shift['carbonType'] . '|' . $shift['shiftMin'] . '|' . $shift['shiftMax'];
            
            if (!in_array($key, $seen)) {
                $unique[] = $shift;
                $seen[] = $key;
            }
        }
        
        return $unique;
    }

}