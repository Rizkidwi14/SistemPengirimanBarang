<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PengirimanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'no_stpb' => $this->faker->randomNumber(5, true),
            'driver_id' => $this->faker->numberBetween(1, 5),
            'toko_id' => $this->faker->numberBetween(1, 10),
            // 'tanggal' => $this->faker->date('Y-m-d'),
            'tanggal' => $this->faker->dateTimeBetween('-6 month', 'now'),
            'no_polisi' => $this->faker->bothify('B #### ???'),
            'kategori' => 'reguler',
            'kotak_peluru' => '0',
            'status' => '2',
            'waktu_kirim' => $this->faker->time('H:i:s'),
            'waktu_terima' => $this->faker->time('H:i:s'),
            'penerima' => $this->faker->name(),
        ];
    }
}
