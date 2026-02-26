<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Molecule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ByNameController extends Controller
{
    /**
     * Carga la vista del buscador por nombre
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get(Request $request) {

        if($request->ajax()) {
            $families = Molecule::distinct()
                ->select('family')
                ->whereBetween('state', ['1', '4'])
                ->where('deleted_at', null)
                ->orderBy('family')
                ->remember(config('rememberTime.time'))
                ->get();
            $data['families'] = $families;

            if($request->family) {
                $subFamilies = Molecule::distinct()
                    ->select('subFamily')
                    ->whereBetween('state', ['1', '4'])
                    ->where('deleted_at', null)
                    ->where('family', $request->family)
                    ->orderBy('subFamily')
                    ->remember(config('rememberTime.time'))
                    ->get();
                $data['subFamilies'] = $subFamilies;

                if($request->subFamily) {
                    $subSubFamilies = Molecule::distinct()
                        ->select('subSubFamily')
                        ->whereBetween('state', ['1', '4'])
                        ->where('deleted_at', null)
                        ->where('family', $request->family)
                        ->where('subFamily', $request->subFamily)
                        ->orderBy('subSubFamily')
                        ->remember(config('rememberTime.time'))
                        ->get();
                    $data['subSubFamilies'] = $subSubFamilies;
                }
            }
            return response()->json($data);
        }

        return view('search.byName');
    }

    /**
     * Comprueba los datos enviados por el formulario
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post(Request $request) {
        //Si se ha pulsado buscar
        if($request->submitBtn) {
            $this->validateForm($request);
            $this->queryMolecules($request);
            return redirect('results/'.sizeof(Session::get('history')));
        }
    }

    /**
     * Valida el formulario comprobando que todos los datos sean correctos
     * @param Request $request
     */
    public function validateForm(Request $request) {

        $dataForm = [
            'family' => 'max:255',
            'subFamily' => 'max:255',
            'subSubFamily' => 'max:255',

            // MODIFICADO: Solo requiere al menos uno de los 3 campos principales
            'emptyError' => 'required_without_all:family,subFamily,subSubFamily',
        ];

        $this->validate($request, $dataForm);
    }

    /**
     * Devuelve el resultado de la consulta
     * MODIFICADO: Solo busca por Family, Type (subFamily), Group (subSubFamily)
     * @param Request $request
     * @return mixed
     */
    public function queryMolecules(Request $request) {
        if(Session::has('history')) {
            $history = Session::get('history');
        }
        
        $criteria = [];
        
        // ========================================
        // SOLO BUSCAR POR ESTOS 3 CAMPOS
        // ========================================
        
        //Si la familia no esta vacia
        if(!empty($request->family)) {
            $criteria['family'] = $request->family;
        }
        //Si la subfamilia no esta vacia
        if(!empty($request->subFamily)) {
            $criteria['subFamily'] = $request->subFamily;
        }
        //Si la subSubFamilia no esta vacia
        if(!empty($request->subSubFamily)) {
            $criteria['subSubFamily'] = $request->subSubFamily;
        }

        // ========================================
        // TODOS LOS DEMÁS CAMPOS SON IGNORADOS
        // ========================================
        // Los campos ca, hi, ni, ox, s, fl, cl, br, io (fórmula molecular)
        // minWeight, maxWeight (peso molecular)
        // triName, semiName (nombres)
        // authors, magazine, year, volume, page (bibliografía)
        // NO se usan en la búsqueda

        //Guardamos en el ultimo elemento del historial
        $history[] = [
            'criteria' => $criteria,
            'type' => 'byName',
            'count' => 0,
        ];
        Session::put('history', $history);
    }
}
