<?php

namespace App\Http\Controllers;

use App\Bibliography;
use App\Carbon;
use App\Http\Requests;
use App\Molecule;

class PropertiesController extends Controller
{
    /*
     * Devuelve la vista correspondiente con los datos asociados a la id especificada.
     */
    public function get($id){
        $data['molecule'] = Molecule::find($id);
        if(!is_null($data['molecule'])) {
            $data['molecularFormula'] = $this->getFormula($data['molecule']);
            $data['bibliography'] = Bibliography::find($data['molecule']->bibliography);
            $data['solvent'] = $this->getThinner($data['molecule']->solvent);
            $data['carbons'] = Carbon::select('numeration', 'carbonType', 'shift', 'num2')
                ->where('molecularId', $id)
                ->orderBy('num2', 'asc')
                ->get();
            $data['reference'] = $data['molecule']->reference;

            if(isset($_GET['atomos'])){
                $data['atomos']=$_GET['atomos'];
                $data['numeracion']=$_GET['numeracion'];
                $data['diferencia']=$_GET['diferencia'];
            }

            return view('search.properties', $data);
        }
        else
            return view('home');
    }

    /**
     * Devuelve la formula con formato
     * @param $molecule
     * @return string
     */
    public function getFormula($molecule) {
        $form = "";
        for ($i = 0; $i < strlen($molecule->molecularFormula); $i++) {
            if (is_numeric(substr($molecule->molecularFormula, $i, 1))) {
                $form .= "<sub>".substr($molecule->molecularFormula, $i, 1)."</sub>";
            } else {
                $form .= substr($molecule->molecularFormula, $i, 1);
            }
        }
        return $form;
    }

    /**
     * Devuelve el disolvente a partir de la letra de la base de datos
     * @param $char
     * @return string
     */
    public function getThinner($char) {
        $solvent = "";

        $sub = ['&#8803', '&#8321', '&#8322', '&#8323', '&#8324', '&#8325', '&#8326', '&#8327', '&#8328', '&#8329'];

        switch($char) {
            case "C+C":
                $solvent = "CDCl" . $sub[3];
                break;
            case "C":
                $solvent = "CDCl" . $sub[3];
                break;
            case "M":
                $solvent = "CD" . $sub[3] . "OD";
                break;
            case "M+M":
                $solvent = "CD" . $sub[3] . "OD";
                break;
            case "A":
                $solvent = "CD" . $sub[3] . "COCD" . $sub[3];
                break;
            case "A+A":
                $solvent = "CD" . $sub[3] . "COCD" . $sub[3];
                break;
            case "P":
                $solvent = "C" . $sub[5] . "D" . $sub[5] . "N";
                break;
            case "P+P":
                $solvent = "C" . $sub[5] . "D" . $sub[5] . "N";
                break;
            case "D":
                $solvent = "DMSO-d" . $sub[6];
                break;
            case "D+D":
                $solvent = "DMSO-d" . $sub[6];
                break;
            case "DMSO":
                $solvent = "DMSO-d" . $sub[6];
                break;
            case "C+D":
                $solvent = "CDDl" . $sub[3] . " + DMSO-d" . $sub[6];
                break;
            case "C+M":
                $solvent = "CDCl" . $sub[3] ." + ". "CD" . $sub[3] . "OD";
                break;
            case "C+Ac":
                $solvent = "CDDl" . $sub[3] ." + ". "CD" . $sub[3] . "C≡N";
                break;
            case "M+W":
                $solvent = "CD" . $sub[3] . "OD" . " + D" . $sub[2] . "O";
                break;
            case "Ac":
                $solvent = "CD" . $sub[3] . "C≡N";
                break;
            case "Ac+Ac":
                $solvent = "CD" . $sub[3] . "C≡N";
                break;

            case "B":
                $solvent = "C" . $sub[6] . "D" . $sub[6];
                break;
            case "B+B":
                $solvent = "C" . $sub[6] . "D" . $sub[6];
                break;
            case "W":
                $solvent = "D" . $sub[2] . "O";
                break;
            case "W+W":
                $solvent = "D" . $sub[2] . "O";
                break;
            case "T":
                $solvent = "CCl" . $sub[4];
                break;
            case "T+T":
                $solvent = "CCl" . $sub[4];
                break;
            case "DC":
                $solvent = "CD" . $sub[2] . "Cl" . $sub[2];
                break;
            case "F":
                $solvent = "CF" . $sub[3] . "COOD";
                break;
            case "F+F":
                $solvent = "CF" . $sub[3] . "COOD";
                break;
            case "Di":
                $solvent = "1,4-Dioxane";
                break;
            case "Di+Di":
                $solvent = "1,4-Dioxane";
                break;
            case "AT":
                $solvent = "CF" . $sub[3] . "CO" . $sub[2] . "H";
                break;
            case "AT+AT":
                $solvent = "CF" . $sub[3] . "CO" . $sub[2] . "H";
                break;

            default:
                $solvent = $char;
                break;
        }
        
        return $solvent;
    }
}
