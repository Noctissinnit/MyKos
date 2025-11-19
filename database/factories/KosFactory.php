<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class KosFactory extends Factory
{
    protected $model = \App\Models\Kos::class;

    public function definition(): array
    {
        // Ensure there's a user (pemilik)
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'nama' => fake()->company(),
            'alamat' => fake()->address(),
            'deskripsi' => fake()->sentence(),
        ];
    }
}
