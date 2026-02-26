<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller {

    public function get() {
        return view('history')
                ->with('history', Session::get('history'));
    }

    public function post(Request $request) {
        if($request->removeBtn) {
            $this->remove($request);
        }
        else if($request->comb) {
            $this->validateForm($request, $request->comb);
            return $this->combination($request, $request->comb);
        }
        return view('history')->with('history', Session::get('history'));
    }

    /**
     * Elimina las busquedas seleccionadas
     * @param Request $request
     */
    public function remove(Request $request) {
        $history = Session::get('history');
        $checked = $request->check;
        foreach($checked as $value) {
            unset($history[$value]);
        }
        $history2 = array_values($history);
        Session::put('history', $history2);
    }

    /**
     * Metodo que gestiona las busquedas combinadas
     * @param Request $request
     * @param $combination
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function combination(Request $request, $combination) {
        $history = Session::get('history');
        $checked = $request->check;
        $whereRaw = "";
        $bindingsAux = [];
        $criteria = [];

        if($combination == '2not1') $checked = array_reverse($checked);
        
        // Verificar que el historial no esté vacío
        if (empty($history) || empty($checked)) {
            return redirect('history')->with('error', 'No hay búsquedas seleccionadas para combinar');
        }
        
        // Para OR, detectar si las búsquedas son idénticas
        if($combination == 'or' && count($checked) == 2) {
            $search1 = $history[$checked[0]] ?? null;
            $search2 = $history[$checked[1]] ?? null;
            
            // Verificar que ambas búsquedas existan y tengan whereRaw
            if ($search1 === null || $search2 === null) {
                return redirect('history')->with('error', 'Una de las búsquedas seleccionadas no existe');
            }
            
            if (!isset($search1['whereRaw']) || !isset($search2['whereRaw'])) {
                return redirect('history')->with('error', 'Las búsquedas seleccionadas no tienen consultas guardadas');
            }
            
            // Comparar los whereRaw directamente
            if($search1['whereRaw'] === $search2['whereRaw']) {
                // Son idénticas, usar solo una
                $whereRaw = $search1['whereRaw'];
                $bindingsAux = $search1['whereBindings'] ?? [];
                $criteria = $search1['criteria'] ?? [];
            } else {
                // Procesar normalmente
                foreach($checked as $index => $value) {
                    // Verificar que el elemento exista y tenga whereRaw
                    if (!isset($history[$value]) || !is_array($history[$value])) {
                        continue;
                    }
                    
                    if (!isset($history[$value]['whereRaw'])) {
                        continue;
                    }
                    
                    $whereAux = $history[$value]['whereRaw'];
                    
                    // Verificar que tenga whereBindings
                    if (isset($history[$value]['whereBindings']) && is_array($history[$value]['whereBindings'])) {
                        foreach($history[$value]['whereBindings'] as $ind => $val) {
                            $bindingsAux[] = $val;
                        }
                    }

                    if($index != 0) {
                        $criteria[] = $combination;
                        $whereRaw = "(" . $whereRaw . ") or (" . $whereAux . ")";
                    }
                    else {
                        $whereRaw = $history[$value]['whereRaw'];
                    }
                    
                    if (isset($history[$value]['criteria'])) {
                        $criteria[] = $history[$value]['criteria'];
                    }
                }
            }
        } else {
            // Procesamiento normal para AND, NOT, etc.
            foreach($checked as $index => $value) {
                // Verificar que el elemento exista y tenga whereRaw
                if (!isset($history[$value]) || !is_array($history[$value])) {
                    continue;
                }
                
                if (!isset($history[$value]['whereRaw'])) {
                    continue;
                }

                //Nos quedamos con el where
                $whereAux = $history[$value]['whereRaw'];
                
                // Verificar que tenga whereBindings
                if (isset($history[$value]['whereBindings']) && is_array($history[$value]['whereBindings'])) {
                    foreach($history[$value]['whereBindings'] as $ind => $val) {
                        $bindingsAux[] = $val;
                    }
                }

                if($index != 0) {
                    $criteria[] = $combination;
                    if($combination == 'and')
                        // $whereRaw.=" and ".$whereAux;
                        $whereRaw = "(" . $whereRaw . ") and (" . $whereAux . ")";
                    else if($combination == 'or')
                        // $whereRaw.=" or ".$whereAux;
                        $whereRaw = "(" . $whereRaw . ") or (" . $whereAux . ")";
                    else if(strpos($combination, 'not') != false)
                        //$whereRaw.=" and not ".$whereAux;
                        $whereRaw = "(" . $whereRaw . ") and not (" . $whereAux . ")";
                }
                else {
                    $whereRaw = $history[$value]['whereRaw'];
                }
                
                if (isset($history[$value]['criteria'])) {
                    $criteria[] = $history[$value]['criteria'];
                }
            }
        }

        // Verificar que se haya construido algo
        if (empty($whereRaw)) {
            return redirect('history')->with('error', 'No se pudieron combinar las búsquedas seleccionadas');
        }

        if(!isset($bindingsAux)) $bindingsAux = array();


        //Guardamos en el ultimo elemento del historial
        $newHistory = [
            'criteria' => $criteria,
            'type' => 'comb',
            'count' => 0,
            'whereRaw' => $whereRaw,
            'whereBindings' => $bindingsAux,
            'selected' => null,

        ];

        $history[] = $newHistory;
        Session::put('history', $history);
        return redirect('results/'.sizeof(Session::get('history')));
    }

    /**
     * Metodo recursivo que presenta el criterio de busqueda en formato HTML
     * @param $criteria
     * @return string
     */
    public static function combineCriteria($criteria) {
        $str = "";
        $carbonTypes = [
            'Cs' => 'C*',
            'CHs' => 'CH*',
            'CH2s' => 'CH<sub>2</sub>*',
            'CH3s' => 'CH<sub>3</sub>*',
            'COs' => 'C-O*',
            'CHOs' => 'CH-O*',
            'CH2Os' => 'CH<sub>2</sub>-O*',
            'CH3Os' => 'CH<sub>3</sub>-O*',
            'CNs' => 'C-N*',
            'CHNs' => 'CH-N*',
            'CH2Ns' => 'CH<sub>2</sub>-N*',
            'CH3Ns' => 'CH<sub>3</sub>-N*',
            'C' => 'C',
            'CH' => 'CH',
            'CH2' => 'CH<sub>2</sub>',
            'CH3' => 'CH<sub>3</sub>',
            'CO' => 'C-O',
            'CHO' => 'CH-O',
            'CH2O' => 'CH<sub>2</sub>-O',
            'CH3O' => 'CH<sub>3</sub>-O',
            'CN' => 'C-N',
            'CHN' => 'CH-N',
            'CH2N' => 'CH<sub>2</sub>-N',
            'CH3N' => 'CH<sub>3</sub>-N',
            'O' => 'O',
            'N' => 'N',
            'H' => 'H',
            'F' => 'F',
            'Cl' => 'Cl',
            'Br' => 'Br',
            'I' => 'I',
            'P' => 'P',
            'S' => 'S',
            'CTali' => 'CT ali',
            'CTaro' => 'CT aro',
            'CTole' => 'CT ole',
            'Csp2' => 'Csp<sup>2</sup>',
            'Cali' => 'C ali',
            'CHali' => 'CH ali',
            'CH2ali' => 'CH<sub>2</sub> ali',
            'COali' => 'C-O ali',
            'CHOali' => 'CH-O ali',
            'CNali' => 'C-N ali',
            'CHNali' => 'CH-N ali',
            'Caro' => 'C aro',
            'CHaro' => 'CH aro',
            'COaro' => 'C-O aro',
            'CHOaro' => 'CH-O aro',
            'CNaro' => 'C-N aro',
            'CHNaro' => 'CH-N aro',
            'Cole' => 'C ole',
            'CHole' => 'CH ole',
            'CH2ole' => 'CH<sub>2</sub> ole',
            'CCarbonil' => 'C=O',
        ];

        foreach($criteria as $key => $value){
            if(is_numeric($key) && is_array($value))
                $str.=self::combineCriteria($value);
            else {
                if($value != 'or' && $value != 'and' && $value != '1not2' && $value != '2not1') {
                    if($key != 'smileCode' && $key != 'jmeCode') {
                        if ($key == 'shiftsArray') {
                            foreach ($criteria[$key] as $element) {
                                $carbonType = $element['carbonType'];
                                if ($carbonType == 'unknown') { $carbonType = 'C,CH,CH<sub>2</sub>,CH<sub>3</sub>'; }
                                if ($carbonType == 'e') { $carbonType = 'CH,CH<sub>3</sub>'; }
                                if ($carbonType == 'CH2') { $carbonType = 'CH<sub>2</sub>'; }
                                if ($carbonType == 'CH3') { $carbonType = 'CH<sub>3</sub>'; }

                                $str.="<span>" . $carbonType . ", &delta; " . (($element['shiftMax']) - (($element['shiftMax'] - $element['shiftMin']) / 2)) . " (&plusmn; " . (($element['shiftMax'] - $element['shiftMin']) / 2) . ") ppm</span><br>";
                            }
                        } elseif ($key == 'carbonTypes') {
                            foreach ($criteria[$key] as $element) {
                                $str.="<span>" . $carbonTypes[$element['label']] . ": [".$element['min'].", ".$element['max']."]</span><br>";
                            }
                        }
                        else {
                            if($key=='molecularFormula'){
                                $for = preg_replace('/\(\?\:[^\)]*\)\?/i', "", $value);
                                $for = preg_replace('/(\d+)/i', "<sub>$1</sub>", $for);
                                $for = substr($for, 1, strlen($for) - 2);
                            } else {
                                $for="";
                                for ($i = 0; $i < strlen($value); $i++) {
                                    if (is_numeric(substr($value, $i, 1)) && is_numeric(substr($value, 0, 1))==false) {
                                        $for.= "<sub>".substr($value, $i, 1)."</sub>";
                                    } else {
                                        $for .= substr($value, $i, 1);
                                    }
                                }
                            }
                            if (!empty($for)) {
                                $str.="<span><b>".trans('applicationResource.criteria.'.$key).":</b> ".$for."</span><br>";
                            }
                        }
                    }
                    else if(!empty($criteria['jmeCode']) && $key == 'jmeCode') {
                        $str.="<div class='jmeDiv' jme='".$criteria['jmeCode']."'></div>";
                    }
                }
                else {
                    if($value == '1not2' || $value == '2not1')
                        $str.="<strong>not</strong></br>";
                    else
                        $str.="<strong>".$value."</strong></br>";
                }
            }
        }
        return $str;
    }

    /**
     * Valida el formulario comprobando que todos los datos sean correctos
     * @param Request $request
     * @param $combination
     */
    public function validateForm(Request $request, $combination) {
        $dataForm = array();
        if($combination == 'and' || $combination == 'or')
            $dataForm = [
                'check' => 'required|array|min:2',
            ];
        else if($combination == '1not2' || $combination == '2not1')
            $dataForm = [
                'check' => 'required|array|min:2|max:2',
            ];

        $this->validate($request, $dataForm);
    }
}