<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KamarFactory extends Factory
{
    protected $model = \App\Models\Kamar::class;

    public function definition(): array
    {
        return [
            'kos_id' => \App\Models\Kos::factory(),
            'nomor' => fake()->bothify('KMR-###'),
            'kelas' => fake()->randomElement(['ekonomi','standar','premium']),
            'harga' => fake()->numberBetween(500000, 3000000),
            'status' => 'kosong',
        ];
    }
}
