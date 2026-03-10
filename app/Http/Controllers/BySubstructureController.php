<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Molecule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class BySubstructureController extends Controller
{
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

        return view('search.bySubstructure');

       }

    public function post(Request $request) {
        if($request->submitBtn) {
            $this->validateForm($request);
            $this->queryMolecules($request);
            //return dd($this->queryMolecules($request));
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
            'smileCode' => '',
            'jmeCode' => '',
            'emptyError' => 'required_without_all:family,subFamily,subSubFamily,smileCode,jmeCode',
        ];

        $this->validate($request, $dataForm);
    }

    public function queryMolecules(Request $request) {
        if(Session::has('history')) {
            $history = Session::get('history');
        }
        if(!empty($request->family)) {
            //$molecules->where('family', $request->family);
            $criteria['family'] = $request->family;
        }
        if(!empty($request->subFamily)) {
            //$molecules->where('subFamily', $request->subFamily);
            $criteria['subFamily'] = $request->subFamily;
        }
        if(!empty($request->subSubFamily)) {
            //$molecules->where('subSubFamily', $request->subSubFamily);
            $criteria['subSubFamily'] = $request->subSubFamily;
        }
        if(!empty($request->stereo)){
            $criteria['stereo'] = $request->stereo;
        }
        if(!empty($request->smileCode)){
            $criteria['smileCode']=preg_replace('|%|', ';', $request->smileCode);
        }
        if(!empty($request->jmeCode)){
            $criteria['jmeCode']=$request->jmeCode;
        }
        $history[] = [
            'criteria' => $criteria,
            'type' => 'bySubstructure',
            'count' => 0,
        ];

        Session::put('history', $history);
    }

}
