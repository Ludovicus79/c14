<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Molecule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSearchController extends Controller
{
    public function get(Request $request)
    {
        return view('admin.adminSearch');
    }

    public function post(Request $request)
    {
        $this->validateForm($request);
        if(!empty($request->id)){
            $molecules= DB::select('select * from molecules where id = ?', [$request->id]);
        }
        if(!empty($request->reference)){
            $molecules= DB::select('select * from molecules where reference like ?', [$request->reference.'%']);
        }

        if (sizeof($molecules) == 1) {
            return redirect('admin/molEdit/'.$molecules[0]->id);
        } else if(sizeof($molecules)==0) {
            return redirect('admin/search/')->with('message', trans('applicationResource.errors.busquedaNull'));
        }else{
            return view('admin.adminSearch',['molecules'=>$molecules]);
        }
    }

    public function destroy(Request $request)
    {

        $checked=$request->check;

        // Elimino la molécula y las filas de otras tablas en las que es referenciada
        foreach ($checked as $value) {
            DB::delete('delete from carbons where molecularId = ?', [$value]);
            DB::delete('delete from carbonTypes where molecularId = ?', [$value]);
            DB::delete('delete from molecules where id = ?', [$value]);
        }

        // Para que se actualice la búsqueda después de haberlos eliminado
        $ref=array();
        $ref=explode("_", $request->reference);
        $refSearch="";
        for ($i=0; $i < sizeof($ref)-1; $i++) {
            $refSearch.=$ref[$i]."_";
        }

        $molecules= DB::select('select * from molecules where reference like ?', [$refSearch.'%']);
        return view('admin.adminSearch',['molecules'=>$molecules]);
    }

    public function validateForm(Request $request)
    {
        $dataForm = [
            'reference' => 'required_without:id',
            'id' => 'required_without:reference',
            'emptyError' => 'required_without_all:reference,id',
        ];

        $this->validate($request, $dataForm);

        return true;
    }
}
