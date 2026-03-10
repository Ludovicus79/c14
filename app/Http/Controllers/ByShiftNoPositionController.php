<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Molecule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ByShiftNoPositionController extends Controller
{
    //
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
        return view('search.byShiftNoPosition');
    }

    public function post(Request $request) {
        if($request->submitBtn) {
            //dd($request);
            $this->validateForm($request);
            $this->queryMolecules($request);
            return redirect('results/' . sizeof(Session::get('history')));
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
            'minCarbons' => 'numeric | filled | min:1',
            'shiftsArray' => 'required | array | min:1',
            'shiftsArray.*.shiftMin' => 'numeric | filled',
            'shiftsArray.*.shiftMax' => 'numeric | filled',
            'shiftsArray.*.tolerance' => 'numeric | filled | max:6',
        ];

        $this->validate($request, $dataForm);
    }

    public function queryMolecules(Request $request) {
        if(Session::has('history')) {
            $history = Session::get('history');
        }
        if(!empty($request->family)) {
            $criteria['family'] = $request->family;
        }
        if(!empty($request->subFamily)) {
            $criteria['subFamily'] = $request->subFamily;
        }
        if(!empty($request->subSubFamily)) {
            $criteria['subSubFamily'] = $request->subSubFamily;
        }
        if(!empty($request->minCarbons)) {
            $criteria['minCarbons'] = $request->minCarbons;
        }

        //Por validación debe haber por lo menos un elemento en el array de desplazamientos.
        $criteria['shiftsArray']=$request->shiftsArray;

        //Guardamos en el ultimo elemento del historial
        $history[] = [
            'criteria' => $criteria,
            'type' => 'byShiftNoPosition',
            'count' => 0,
        ];
        Session::put('history', $history);
    }
}


