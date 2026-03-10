<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function get(Request $request){
        return view('admin.config');
    }
}
