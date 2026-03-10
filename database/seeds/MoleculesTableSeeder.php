<?php

    use Illuminate\Database\Seeder;

    class MoleculesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $filename=file_get_contents(base_path()."/database/seeds/sqlFiles/molecules.sql");
        DB::unprepared($filename);
    }
}
