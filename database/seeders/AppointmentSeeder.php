<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Patient::all();
        $medicos = Doctor::all();

        $estados = ['pendiente', 'confirmada', 'atendida', 'cancelada'];

        foreach (range(1, 15) as $i) {
            $paciente = $pacientes->random();
            $medico = $medicos->random();

            Appointment::create([
                'patient_id' => $paciente->id,
                'doctor_id' => $medico->id,
                'specialty_id' => $medico->specialty_id,
                'fecha' => now()->addDays(rand(-5, 15))->toDateString(),
                'hora' => sprintf('%02d:00:00', rand(8, 16)),
                'motivo_consulta' => 'Consulta de control general.',
                'estado' => $estados[array_rand($estados)],
            ]);
        }
    }
}
