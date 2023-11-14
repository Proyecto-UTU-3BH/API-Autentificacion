<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'usuario' => $this-> faker->email(),
            'ci' => $this-> faker->numerify('########'),
            'password' => Hash::make($this-> faker->password),
            'primer_nombre' => $this-> faker->firstName(),
            'primer_apellido' => $this-> faker->lastname(),
            'segundo_apellido' => $this-> faker->optional()->lastname(),
            'calle' => $this-> faker->streetName(),
            'numero_de_puerta' => $this-> faker->buildingNumber(),
            'tipo' => $this-> faker-> randomElement($array = array ('chofer','funcionario')),
            'telefono' => $this-> faker-> numberBetween($min = 94000000, $max = 94999999),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
