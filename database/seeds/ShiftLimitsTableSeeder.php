<?php

    use Illuminate\Database\Seeder;

    class ShiftLimitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename=file_get_contents(base_path()."/database/seeds/sqlFiles/shiftLimits.sql");
        DB::unprepared($filename);
    }
}
