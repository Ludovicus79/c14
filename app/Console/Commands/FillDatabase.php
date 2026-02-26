<?php

namespace App\Console\Commands;

use App\Helpers\CarbonTypesCalculator;
use App\Molecule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FillDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert All Data in Database';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Vaciamos las tablas primero
        DB::table('carbons')->delete();
        DB::table('molecules')->delete();
        DB::table('bibliographies')->delete();
        DB::table('authors')->delete();
        DB::table('shiftLimits')->delete();
        DB::table('atomicWeights')->delete();
        DB::table('carbonTypes')->delete();

        ini_set('memory_limit', '-1');
        DB::statement('SET GLOBAL max_allowed_packet=100*1024*1024');
        echo 'Filling Database, this could take a while.'.PHP_EOL;
        $filename = file_get_contents(base_path().'/database/fill/sqlFiles/authors.sql');
        echo 'Inserting Authors Table...'.PHP_EOL;
        DB::unprepared($filename);
        $filename = file_get_contents(base_path().'/database/fill/sqlFiles/bibliographies.sql');
        echo 'Inserting Bibliographies Table...'.PHP_EOL;
        DB::unprepared($filename);
        $filename = file_get_contents(base_path().'/database/fill/sqlFiles/molecules.sql');
        echo 'Inserting Molecules Table...'.PHP_EOL;
        DB::unprepared($filename);
        $filename = file_get_contents(base_path().'/database/fill/sqlFiles/carbons.sql');
        echo 'Inserting Carbons Table...'.PHP_EOL;
        DB::unprepared($filename);
        $filename = file_get_contents(base_path().'/database/fill/sqlFiles/shiftLimits.sql');
        echo 'Inserting ShiftLimits Table...'.PHP_EOL;
        DB::unprepared($filename);
        $filename = file_get_contents(base_path().'/database/fill/sqlFiles/atomicWeights.sql');
        echo 'Inserting AtomicWeights Table...'.PHP_EOL;
        DB::unprepared($filename);
        echo 'Getting CarbonTypes from Molecules...'.PHP_EOL;
        $molecules = Molecule::all();
        $total = sizeof($molecules);
        foreach($molecules as $index => $molecule) {
            CarbonTypesCalculator::saveCarbonTypes($molecule->id, $molecule->smilesNumeration, $molecule->molecularFormula);
            $this->show_status($index+1, $total);
        }
        Cache::flush();
        echo 'Done!'.PHP_EOL;
    }

    /**
     * Muestra una barra de progreso
     * @param $done
     * @param $total
     * @param int $size
     */
    function show_status($done, $total, $size=30) {

        static $start_time;

        // if we go over our bound, just ignore it
        if($done > $total) return;

        if(empty($start_time)) $start_time=time();
        $now = time();

        $perc=(double)($done/$total);

        $bar=floor($perc*$size);

        $status_bar="\r[";
        $status_bar.=str_repeat("=", $bar);
        if($bar<$size){
            $status_bar.=">";
            $status_bar.=str_repeat(" ", $size-$bar);
        } else {
            $status_bar.="=";
        }

        $disp=number_format($perc*100, 0);

        $status_bar.="] $disp%  $done/$total";

        $rate = ($now-$start_time)/$done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);

        $elapsed = $now - $start_time;

        $status_bar.= " remaining: ".number_format($eta)." sec.  elapsed: ".number_format($elapsed)." sec.";

        echo "$status_bar  ";

        flush();

        // when done, send a newline
        if($done == $total) {
            echo "\n";
        }

    }
}
