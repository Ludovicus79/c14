<?php

    use Illuminate\Database\Seeder;

    class CarbonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $filename=file_get_contents(base_path()."/database/seeds/sqlFiles/carbons.sql");
        DB::unprepared($filename);
    }
}
