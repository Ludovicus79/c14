<?php

namespace App\Console\Commands;

use App\Helpers\CarbonTypesCalculator;
use App\Molecule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FillCarbonTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:carbonTypes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate carbon types';

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
        //Vaciamos la tabla primero
        DB::table('carbonTypes')->delete();

        ini_set('memory_limit', '-1');
        DB::statement('SET GLOBAL max_allowed_packet=100*1024*1024');
        echo 'Recalculating carbonTypes, this could take a while.'.PHP_EOL;
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
