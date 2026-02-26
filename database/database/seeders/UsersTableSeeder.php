<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'login' => 'admin',
            'name' => 'Administrador',
            'email' => 'admin@naproc13.com',
            'password' => Hash::make('admin123'),
            'university' => 'Universidad de Salamanca',
            'city' => 'Salamanca',
            'country' => 'España',
            'is_admin' => true,
            'allowed' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}