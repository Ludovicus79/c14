<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MoleculesWithDOIImport;

class ImportDOIData extends Command
{
    protected $signature = 'import:doi {file}';
    protected $description = 'Import molecules with DOI from Excel files';

    public function handle()
    {
        $file = $this->argument('file');
        
        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return 1;
        }

        $this->info("Importing: {$file}");
        
        Excel::import(new MoleculesWithDOIImport, $file);
        
        $this->info("✓ Import completed!");
        return 0;
    }
}