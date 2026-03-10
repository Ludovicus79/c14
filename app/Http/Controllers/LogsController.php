<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\File;
use ZipArchive;

class LogsController extends Controller
{
    /*
     * Devuelve la vista correspondiente con los datos de los logs encontrados.
     */
    public function get($fileName = null)
    {
        if (empty($fileName)) {
            $logs = File::allFiles(config('logDownload.logsFolder'));
            if (sizeof($logs) > 0) {
                foreach ($logs as $log) {
                    $data[File::lastModified($log->getPathname())] = ($log);
                }
                krsort($data);
                $logs = array_values($data);
            }
            return view('admin.logs', ['logs' => $logs]);
        }
        
        // CORRECCIÓN: Construir la ruta completa del archivo
        $filePath = config('logDownload.logsFolder') . $fileName;
        
        // CORRECCIÓN: Verificar que el archivo existe antes de leerlo
        if (!File::exists($filePath)) {
            // Redirigir a la lista de logs con mensaje de error
            return redirect()->back()->with('error', 'El archivo de log no existe: ' . $fileName);
        }
        
        $content = File::get($filePath);
        return view('admin.logDetail', ['content' => $content]);
    }

    /*
     * Descarga el fichero asociado al log solicitado.
     */
    public function download($fileName)
    {
        // CORRECCIÓN: Verificar que el archivo existe antes de descargar
        $filePath = config('logDownload.logsFolder') . $fileName;
        
        if ($fileName != 'all' && !File::exists($filePath)) {
            return redirect()->back()->with('error', 'El archivo no existe: ' . $fileName);
        }
        
        if ($fileName=='all') {
            $zip = new ZipArchive;
            $tmpPath = config('logDownload.logsFolder');
            $zipFileName = 'logs.zip';

            if ($zip->open($tmpPath . DIRECTORY_SEPARATOR . $zipFileName, ZipArchive::CREATE) === true) {

                $logs = File::allFiles(config('logDownload.logsFolder'));

                foreach ($logs as $log) {
                    $logName = basename($log);
                    $zip->addFile($log, $logName);
                }

                $zip->close();

                return response()->download(config('logDownload.logsFolder') . $zipFileName)->deleteFileAfterSend(true);

            }

        } else {
            return response()->download($filePath);
        }
    }


    /*
     * Borra el archivo del log solicitado
     */
    public function delete($fileName)
    {
        if ($fileName == "all") {
            File::cleanDirectory(config('logDownload.logsFolder'));
        } else {
            // CORRECCIÓN: Verificar que el archivo existe antes de borrar
            $filePath = config('logDownload.logsFolder') . $fileName;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        return back();
    }
}