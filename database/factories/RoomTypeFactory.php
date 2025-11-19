<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    protected $model = \App\Models\RoomType::class;

    public function definition(): array
    {
        return [
            'kos_id' => \App\Models\Kos::factory(),
            'nama' => fake()->randomElement(['Single', 'Double', 'Suite']),
            'kapasitas' => fake()->numberBetween(1, 4),
            'harga' => fake()->numberBetween(500000, 3000000),
            'deskripsi' => fake()->sentence(),
        ];
    }
}
