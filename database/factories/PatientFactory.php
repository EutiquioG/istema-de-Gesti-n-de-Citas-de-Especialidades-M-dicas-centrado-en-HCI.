<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'tipo_documento' => $this->faker->randomElement(['CC', 'TI', 'CE']),
            'numero_documento' => $this->faker->unique()->numerify('##########'),
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-80 years', '-1 years'),
            'telefono' => $this->faker->numerify('3#########'),
            'correo' => $this->faker->unique()->safeEmail(),
            'direccion' => $this->faker->address(),
            'estado' => 'activo',
        ];
    }
}
