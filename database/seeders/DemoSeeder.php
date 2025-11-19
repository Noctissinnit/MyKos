<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kos;
use App\Models\RoomType;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create a pemilik with kos and room types
        $pemilik = User::firstOrCreate(
            ['email' => 'pemilik@example.com'],
            [
                'name' => 'Pemilik Demo',
                'role' => 'pemilik',
                'password' => bcrypt('password'),
            ]
        );

        $kos = Kos::firstOrCreate([
            'user_id' => $pemilik->id,
        ], [
            'nama' => 'Kos Demo',
            'alamat' => 'Jl. Contoh No.1',
            'deskripsi' => 'Kos demo untuk testing',
        ]);

        if ($kos->roomTypes()->count() === 0) {
            RoomType::factory()->count(3)->create(['kos_id' => $kos->id]);
        }

        // Create a regular user if not exists
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Demo',
                'role' => 'user',
                'password' => bcrypt('password'),
            ]
        );
    }
}
