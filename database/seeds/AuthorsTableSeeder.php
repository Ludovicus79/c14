<?php

    use Illuminate\Database\Seeder;

    class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = file_get_contents(base_path().'/database/seeds/sqlFiles/authors.sql');
        DB::unprepared($filename);
    }
}
