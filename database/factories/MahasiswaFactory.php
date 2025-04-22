<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama' => fake()->name(),
            'nobp' => fake()->bothify('#########'),
            'email' => fake()->unique()->safeEmail,
            'nohp' => fake()->phoneNumber(),
            'jurusan' => fake()->randomElement(['TI', 'SI', 'SK']),
            'prodi' => fake()->randomElement(['MI', 'TK', 'TRPL', 'Multimedia']),
            'tgllahir' => fake()->date('Y-m-d')
        ];
    }
}
