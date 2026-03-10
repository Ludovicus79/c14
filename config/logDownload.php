<?php
return [
    /*
     * Configuración necesarias sobre rutas y otros aspectos relacionados con la descarga de logs
     */
    'logsFolder' => env('LOG_FOLDER',base_path() . DIRECTORY_SEPARATOR."ExcelErrorLogs".DIRECTORY_SEPARATOR),
]
?>