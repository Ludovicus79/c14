<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed usuarios de prueba para NAPROC13
     */
    public function run(): void
    {
        $users = [
            [
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
            ],
            [
                'login' => 'usuario1',
                'name' => 'Usuario Uno',
                'email' => 'usuario1@example.com',
                'password' => Hash::make('password123'),
                'university' => 'Universidad Complutense',
                'city' => 'Madrid',
                'country' => 'España',
                'is_admin' => false,
                'allowed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'login' => 'usuario2',
                'name' => 'Usuario Dos',
                'email' => 'usuario2@example.com',
                'password' => Hash::make('password123'),
                'university' => 'Universidad de Barcelona',
                'city' => 'Barcelona',
                'country' => 'España',
                'is_admin' => false,
                'allowed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);

        echo "\n✓ Usuarios de prueba creados exitosamente\n";
        echo "\nCredenciales:\n";
        echo "====================\n";
        echo "ADMIN:\n";
        echo "  Login: admin\n";
        echo "  Password: admin123\n";
        echo "\nUSUARIOS:\n";
        echo "  Login: usuario1 / Password: password123\n";
        echo "  Login: usuario2 / Password: password123\n";
        echo "====================\n\n";
    }
}
