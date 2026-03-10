<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ByCarbonTypeController extends Controller
{
    public function get (Request $request){
        return view('search.byCarbonType');
    }

    public function post (Request $request){
        $this->validateForm($request);
        //echo dd($request,$request->range);
        $this->queryMolecules($request);
        return redirect('results/'.sizeof(Session::get('history')));

    }

    public function validateForm(Request $request){
        $dataForm = [
            'range' => 'required | array | min:1',
            'range.*.min' => ' numeric | filled',
            'range.*.max' => ' numeric | filled',
        ];

        $this->validate($request, $dataForm);
    }

    public function queryMolecules(Request $request){

        if(Session::has('history')) {
            $history = Session::get('history');
        }

        $criteria['carbonTypes'] = $request->range;

        $history[] = [
            'criteria' => $criteria,
            'type' => 'byCarbonType',
            'count'=> 0
        ];
        Session::put('history', $history);
    }
}
