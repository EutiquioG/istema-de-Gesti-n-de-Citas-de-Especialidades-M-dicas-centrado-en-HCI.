<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $pacienteUser = User::where('email', 'paciente@citasmedicas.test')->first();

        Patient::create([
            'user_id' => $pacienteUser?->id,
            'tipo_documento' => 'CC',
            'numero_documento' => '1122334455',
            'nombres' => 'María',
            'apellidos' => 'Gómez',
            'fecha_nacimiento' => '1990-05-14',
            'telefono' => '3109876543',
            'correo' => 'paciente@citasmedicas.test',
            'direccion' => 'Calle 10 # 20-30',
            'estado' => 'activo',
        ]);

        // Pacientes adicionales de demostración
        Patient::factory()->count(10)->create();
    }
}
