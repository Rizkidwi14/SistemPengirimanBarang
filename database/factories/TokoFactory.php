<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TokoFactory extends Factory
{
    static $kodeToko = '6A03';
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode_toko' => self::$kodeToko++,
            'nama_toko' => $this->faker->city(),
            'alamat' => $this->faker->city(),
            'operasional' => $this->faker->numberBetween(0, 1),
            'status' => '1',
        ];
    }
}
