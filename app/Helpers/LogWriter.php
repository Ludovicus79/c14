<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 23/04/2016
 * Time: 20:22
 */

namespace App\Helpers;


class LogWriter
{

    /**
     * Patiendo de los datos almacenador en un array crea un archivo de texto a modo de informe.
     * @param $log array con los datos referentes al informe.
     * @return cadena nombre del fichero del informe creado.
     */
    public static function writeExcelLog($log)
    {
        $path = base_path() . DIRECTORY_SEPARATOR . "ExcelErrorLogs" . DIRECTORY_SEPARATOR;
        
        // CORRECCIÓN: Crear el directorio si no existe
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        
        $date = date('d-m-Y_H-i-s');
        $fileName = $log['operacion'] . ".txt";
        
        // CORRECCIÓN: Sanitizar el nombre del archivo (eliminar caracteres no válidos)
        $fileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $fileName);
        
        $resource = fopen($path . $fileName, "w");

        fwrite($resource, "INFORME DE LA OPERACIÓN" . PHP_EOL);
        //fwrite($resource, $log['operacion'] . PHP_EOL);
        //fwrite($resource, "Autor: " . $log['author'] . PHP_EOL);
        //fwrite($resource, "Fecha: " . $date . PHP_EOL);
        fwrite($resource, PHP_EOL);
        foreach ($log['moleculas'] as $molecule) {
            fwrite($resource, "Referencia: " . $molecule['ref'] . PHP_EOL);
            fwrite($resource, "Estado: " . $molecule['status'] . PHP_EOL);
            if (array_key_exists('nRow', $molecule)) {
                fwrite($resource, "Linea del excel: " . $molecule['nRow'] . PHP_EOL);
            }
            
            //fwrite($resource, "--------------------" . PHP_EOL);
            foreach ($molecule['errors'] as $error) {
                fwrite($resource, $error . PHP_EOL);
            }
            if (!empty($molecule['warnings'])) {
                fwrite($resource, "ALERTAS" . PHP_EOL);
                foreach ($molecule['warnings'] as $warning) {
                    fwrite($resource, $warning . PHP_EOL);
                }
            }
            fwrite($resource, "----------------------------------------------------------------------");
            fwrite($resource, PHP_EOL);
        }
        fclose($resource);
        return $fileName;
    }

}