<?php

namespace App\Http\Controllers;

use App;
use App\Author;
use App\Http\Requests;

class PagesController extends Controller
{
    public function contributors()
    {
        $contributors = Author::all();
        return view('contributors', compact('contributors'));
    }

    public function conditions()
    {
        return view('conditions');
    }

    public function acknow()
    {
        return view('acknowledgment');
    }

    public function help()
    {
        return view('help/help');
    }

    public function developers() {
        return view('developers');
    }
}
