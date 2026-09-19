<?php

namespace Database\Factories;

use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'specialty_id' => Specialty::inRandomOrder()->first()?->id
                ?? Specialty::factory(),
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'numero_identificacion' => $this->faker->unique()->numerify('##########'),
            'registro_profesional' => 'RM-' . $this->faker->unique()->numerify('#####'),
            'telefono' => $this->faker->numerify('3#########'),
            'correo' => $this->faker->unique()->safeEmail(),
            'estado' => 'activo',
        ];
    }
}
