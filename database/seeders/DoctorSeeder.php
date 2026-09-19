<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $medicoUser = User::where('email', 'medico@citasmedicas.test')->first();
        $cardiologia = Specialty::where('nombre', 'Cardiología')->first();

        Doctor::create([
            'user_id' => $medicoUser?->id,
            'specialty_id' => $cardiologia->id,
            'nombres' => 'Juan',
            'apellidos' => 'Pérez',
            'numero_identificacion' => '1020304050',
            'registro_profesional' => 'RM-00123',
            'telefono' => '3001234567',
            'correo' => 'medico@citasmedicas.test',
            'estado' => 'activo',
        ]);

        // Médicos adicionales de demostración usando el factory
        Doctor::factory()->count(6)->create();
    }
}
