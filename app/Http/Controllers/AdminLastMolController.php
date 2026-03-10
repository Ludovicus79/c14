<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class AdminLastMolController extends Controller
{
     public function get(Request $requet)
    {
    	$molecules= DB::select('select * from molecules order by id desc limit 30 ');
        return view('admin.adminLastMolecules', ['molecules' => $molecules]);
    }
}
