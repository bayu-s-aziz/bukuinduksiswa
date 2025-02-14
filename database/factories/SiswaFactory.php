<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_panggilan' => $this->faker->name(),
            'nama_lengkap' => $this->faker->name(),
            'nisn' => $this->faker->unique()->randomNumber(5, true),
            'noinduk' => $this->faker->unique()->randomNumber(3, true),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tahun_id' => 1,
            'kelompok_id' => 1,
            'created_at' => now(),
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
