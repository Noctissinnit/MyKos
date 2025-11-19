<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create one admin, one pemilik, one user for testing
        User::factory()->create([
            'name' => 'Admin Demo',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Pemilik Demo',
            'email' => 'pemilik@example.com',
            'role' => 'pemilik',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'User Demo',
            'email' => 'user1@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);
    }
}
