<?php

namespace App\Http\Controllers;

use App\Molecule;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;

class AdminConfirmController extends Controller
{
    /*
     * Devuelve la vista correspondiente con los datos de las moléculas que no están confirmadas.
     * En caso de especificar un id, primero la pasa a estado confirmado y luego continúa con la operación.
     */
    public function get($molId = null)
    {
        if (!empty($molId)) {
            $this->confirmMolecule($molId);
        }
        $molecules = Molecule::where('state', '6')->paginate(15);
        return view('admin.adminConfirmMolecule', ['molecules' => $molecules]);
    }

    public function post(Request $request)
    {
        if (isset ($request->check)) {
            foreach ($request->check as $check => $value) {
                $this->confirmMolecule($value);
            }
        }
        return back();
    }

    private function confirmMolecule($molId)
    {
        $molecule = Molecule::find($molId);
        if (!empty($molecule)) {
            $molecule->state = "1";
            $molecule->save();
            Cache::flush();
        }
    }
}
