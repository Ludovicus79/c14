<?php

namespace App\Http\Controllers;

use App\Author;
use App\Bibliography;
use App\Carbon;
use App\CarbonType;
use App\Helpers\LogWriter;
use App\Helpers\MolUploader;
use App\Http\Requests;
use App\Molecule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMolEditController extends Controller
{
    public function get($molId = null)
    {
        //Petición típica, si se aporta id de molécula carga los datos de esta, en caso contrario carga una nueva vacía.
        $molecularFormula = '';
        if (empty($molId)) {
            $molecule = new Molecule();
            $carbons = array(new Carbon());
            $bibliography = new Bibliography();
            $author = new Author();
        } else {
            $molecule = Molecule::where('id', $molId)->first();
            
            // Verificar PRIMERO si la molécula existe antes de usarla
            if (empty($molecule)) {
                return redirect('/admin/molEdit/');
            }
            
            // Ahora sí podemos usar $molecule porque sabemos que no es null
            $molecularFormula = $this->getFormula($molecule);
            $carbons = $molecule->carbons;
            $bibliography = Bibliography::where('id', $molecule->bibliography)->first();
            $author = Author::where('id', $molecule->authorId)->first();
        }
        return view('admin.adminMolDetail', ['molecule' => $molecule, 'carbons' => $carbons, 'bibliography' => $bibliography, 'author' => $author, 'molecularFormula' => $molecularFormula]);
    }

    public function getFormula($molecule) {
        // Verificar si $molecule es null o no tiene molecularFormula
        if (empty($molecule) || empty($molecule->molecularFormula)) {
            return "";
        }
        
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

    public function post(Request $request)
    {
        set_time_limit(3000);

        if (isset($request->delete)) {
            if ($request->molecule['id'] != "") {
                $idMol=$request->molecule['id'];
                $carbonDel= DB::delete('delete from carbons where molecularId = ?', [$idMol]);
                $carbonTypeDel= DB::delete('delete from carbonTypes where molecularId = ?', [$idMol]);
                $molDel=DB::delete('delete from molecules where id = ?', [$idMol]);
            }

            return redirect(url('/history'));

        } else {
            $this->validateForm($request);
            //Se guardan los datos del request en un array siguiendo el formato que requiere el moluploader.
            $molUploader = new MolUploader();
            $mol = $request->molecule;
            $mol['author'] = $request->author;
            $mol['bibliography'] = $request->bibliography;
            $mol['carbons'] = $request->carbon;
            $molUploader->insert($mol);
            $log['moleculas'][] = $molUploader->getLog();
            $log['author'] = $request->author['author'];
            //$log['id']=$request->id);
            if ($request->molecule['id'] != "") {
                $log['operacion'] = 'Mod Ref ' . $mol['reference'] ." ". date('d-m-Y_H-i-s');
            } else {
                $log['operacion'] = 'Nueva Ref ' . $mol['reference'] ." ". date('d-m-Y_H-i-s');
            }
            $logPath = (LogWriter::writeExcelLog($log));
            return redirect(url('/admin/logs/' . $logPath));
        }
    }

    /*
     * Validación de los datos de la petición.
     */
    public function validateForm(Request $request)
    {
        $rules = [
            'molecule.reference' => 'filled',
            'molecule.family' => 'filled',
            'molecule.solvent' => 'filled',
            'molecule.jmeNumeration' => 'filled',
            'molecule.smilesNumeration' => 'filled',
        ];

        $this->validate($request, $rules);
    }
}
