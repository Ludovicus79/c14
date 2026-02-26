<?php

namespace App\Http\Controllers;

use App\Molecule;
use App\Http\Requests;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
     * Devuelve la vista correspondiente.
     */
    public function get(Request $request)
    {
        return view('admin.index');
    }

    public function normalizedb()
    {
        $order = ['C','H','N','S','F','Cl','Br','I','P','O'];
        $formula = null;
        $updatedformula = null;

        //$molecules = Molecule::limit(50)->where('molecularFormula', 'like', '%S%')->get();
        $molecules = Molecule::all();
        foreach ($molecules as $molecule) {

            // Busqueda de un elemento ordenado correctamente
            preg_match("/^((?:C)?(?:\d+)?)((?:H)?(?:\d+)?)((?:N)?(?:\d+)?)((?:S)?(?:\d+)?)((?:F)?(?:\d+)?)((?:Cl)?(?:\d+)?)((?:Br)?(?:\d+)?)((?:I)?(?:\d+)?)((?:P)?(?:\d+)?)((?:O)?(?:\d+)?)$/", $molecule->molecularFormula, $formula);

            if (!empty($formula)) {
                continue;
            }

            $formula = [];

            foreach ($order as $key => $letter) {
                preg_match('/'.$letter.'(?:\d+)?/', $molecule->molecularFormula, $matches);

                if (isset($matches[0]) && !empty($matches[0])) {
                    array_push($formula, $matches[0]);
                }
            }

            echo $molecule->molecularFormula . "<br />";
            //print_r($formula);

            $updatedformula = "";

            foreach ($order as $key => $letter) {
                foreach ($formula as $index => $text) {
                    $pos = strpos($text, $letter);
                    if ($pos !== false) {
                        $updatedformula .= $text;
                        break;
                    }
                }
            }

            $molecule->molecularFormula = $updatedformula;
            $molecule->save();

            echo $updatedformula;
            echo "<pre>";
            print_r("--------------");
            echo "</pre>";
        }
    }

}



