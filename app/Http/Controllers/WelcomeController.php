<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class WelcomeController extends Controller
{
    public function home() {
    	\Log::debug('Test debug message');
        return view('home');
    }
}
