<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResultsController;
use App\Http\Requests;
use App\Carbon;

use App\Molecule;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AnaliticaController extends Controller
{
    public function get($index)
    {
    	$res= new ResultsController();
       $history = Session::get('history');
        $historyIndex = $history[$index - 1];

        $result = $res->queryMoleculas($historyIndex);

        //Si hay datos relativos a una busqueda iterativa los actualizamos
        if (isset($result['conditions'])) {
            $history[$index - 1]['criteria']['conditions'] = strval($result['conditions']);
        }

        $data['allmol']=$result['allmol'];
        $data['molecules'] = $result['molecules'];
        $data['count'] = $result['count'];


        //Con esto actualizamos el numero de resultados
        $history[$index - 1]['count'] = $result['count'];
        $history[$index - 1]['whereRaw'] = $result['whereRaw'];
        $history[$index - 1]['whereBindings'] = $result['whereBindings'];

        //echo dd($history);
        Session::put('history', $history);
        for($i=0;$i<sizeof($data['allmol']);$i++){
            $r=$data['allmol'][$i]->id;
            $carbons[$i]=DB::select("SELECT Cs,CHs,CH2s,CH3s,COs,CHOs,CH2Os,CH3Os,CNs,CHNs,CH2Ns,CH3Ns,C,CH,CH2,CH3,CO,CHO,CH2O,CH3O,CN,CHN,CH2N,CH3N,O,N,H,F,Cl,Br,I,P,S FROM carbonTypes inner join molecules on carbonTypes.molecularId=molecules.id where molecularId = ?", [$r]);
            $desp[$i]=DB::select("SELECT carbonType,shift,jmeDisplacement,name,family,subFamily,subSubFamily,solvent,molecularFormula FROM carbons inner join molecules on carbons.molecularId=molecules.id where molecularId = ?", [$r]);
            $desplazamientos[$i]=DB::select("SELECT carbonType,shift FROM carbons where molecularId = ?", [$r]);
        }
       
        return view('analitica',$data,['carbons'=>$carbons, 'desp'=>$desp, 'desplazamientos'=>$desplazamientos])->with('history', Session::get('history'));
    }
}
