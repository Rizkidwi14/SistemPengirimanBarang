<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nik' => $this->faker->numerify('##########'),
            'nama' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'email' => $this->faker->email(),
            'no_telepon' => '08' . $this->faker->randomNumber(9, true)
        ];
    }
}
