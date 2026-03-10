<?php

namespace App\Http\Controllers;

use App\Molecule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ByNameController extends Controller
{
    public function get(Request $request)
    {
        if ($request->ajax()) {
            $data = [];

            $families = Molecule::distinct()
                ->select('family')
                ->whereBetween('state', ['1', '4'])
                ->where('deleted_at', null)
                ->orderBy('family')
                ->get();

            $data['families'] = $families;

            if ($request->family) {
                $subFamilies = Molecule::distinct()
                    ->select('subFamily')
                    ->whereBetween('state', ['1', '4'])
                    ->where('deleted_at', null)
                    ->where('family', $request->family)
                    ->orderBy('subFamily')
                    ->get();

                $data['subFamilies'] = $subFamilies;

                if ($request->subFamily) {
                    $subSubFamilies = Molecule::distinct()
                        ->select('subSubFamily')
                        ->whereBetween('state', ['1', '4'])
                        ->where('deleted_at', null)
                        ->where('family', $request->family)
                        ->where('subFamily', $request->subFamily)
                        ->orderBy('subSubFamily')
                        ->get();

                    $data['subSubFamilies'] = $subSubFamilies;
                }
            }

            return response()->json($data);
        }

        return view('search.byName');
    }

    public function post(Request $request)
    {
        $this->validateForm($request);
        $this->queryMolecules($request);
        return redirect('results/' . sizeof(Session::get('history')));
    }

    public function validateForm(Request $request)
    {
        $dataForm = [
            'family'       => 'max:255',
            'subFamily'    => 'max:255',
            'subSubFamily' => 'max:255',
            'trivialName'  => 'max:255',
            'semiName'     => 'max:255',
            'molFormula'   => 'array|nullable',
            'molWeightMin' => 'numeric|nullable',
            'molWeightMax' => 'numeric|nullable',
            'heteroAtom'   => 'max:255',
            'biblio'       => 'max:255',
        ];

        $this->validate($request, $dataForm);
    }

    public function queryMolecules(Request $request)
    {
        if (Session::has('history')) {
            $history = Session::get('history');
        }

        $criteria = [];

        if (!empty($request->family)) {
            $criteria['family'] = $request->family;
        }
        if (!empty($request->subFamily)) {
            $criteria['subFamily'] = $request->subFamily;
        }
        if (!empty($request->subSubFamily)) {
            $criteria['subSubFamily'] = $request->subSubFamily;
        }
        if (!empty($request->trivialName)) {
            $criteria['trivialName'] = $request->trivialName;
        }
        if (!empty($request->semiName)) {
            $criteria['semiName'] = $request->semiName;
        }
        if (!empty($request->molFormula)) {
            $criteria['molFormula'] = $request->molFormula;
        }
        if (!empty($request->molWeightMin)) {
            $criteria['molWeightMin'] = $request->molWeightMin;
        }
        if (!empty($request->molWeightMax)) {
            $criteria['molWeightMax'] = $request->molWeightMax;
        }
        if (!empty($request->heteroAtom)) {
            $criteria['heteroAtom'] = $request->heteroAtom;
        }
        if (!empty($request->biblio)) {
            $criteria['biblio'] = $request->biblio;
        }

        $history[] = [
            'criteria' => $criteria,
            'type'     => 'byName',
            'count'    => 0,
        ];

        Session::put('history', $history);
    }
}
