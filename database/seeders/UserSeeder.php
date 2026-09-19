<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador General',
            'email' => 'admin@citasmedicas.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'medico@citasmedicas.test',
            'password' => Hash::make('password'),
            'role' => 'medico',
        ]);

        User::create([
            'name' => 'María Gómez',
            'email' => 'paciente@citasmedicas.test',
            'password' => Hash::make('password'),
            'role' => 'paciente',
        ]);
    }
}
