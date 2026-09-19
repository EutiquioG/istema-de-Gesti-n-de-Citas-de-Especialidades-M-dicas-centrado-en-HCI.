<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = [
            ['nombre' => 'Medicina General', 'descripcion' => 'Atención médica primaria y general.'],
            ['nombre' => 'Pediatría', 'descripcion' => 'Atención médica para niños y adolescentes.'],
            ['nombre' => 'Cardiología', 'descripcion' => 'Diagnóstico y tratamiento de enfermedades del corazón.'],
            ['nombre' => 'Dermatología', 'descripcion' => 'Diagnóstico y tratamiento de enfermedades de la piel.'],
            ['nombre' => 'Odontología', 'descripcion' => 'Salud oral y dental.'],
            ['nombre' => 'Ginecología', 'descripcion' => 'Salud del sistema reproductivo femenino.'],
        ];

        foreach ($especialidades as $especialidad) {
            Specialty::create($especialidad + ['estado' => 'activo']);
        }
    }
}
