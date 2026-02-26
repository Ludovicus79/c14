<?php

    use Illuminate\Database\Seeder;

    class AtomicWeightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = file_get_contents(base_path().'/database/seeds/sqlFiles/atomicWeights.sql');
        DB::unprepared($filename);
    }
}
