<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'id' => 'banner-1',
                'title' => 'Diskon 20% Kos Pertama',
                'description' => 'Dapatkan diskon 20% untuk penyewaan kos pertama Anda. Promo terbatas!',
                'image' => null,
                'link' => '#',
                'is_active' => true,
                'created_at' => now()->toISOString(),
            ],
            [
                'id' => 'banner-2',
                'title' => 'Kos Premium dengan Fasilitas Lengkap',
                'description' => 'Temukan kos premium dengan AC, WiFi, dan dapur pribadi.',
                'image' => null,
                'link' => '#',
                'is_active' => true,
                'created_at' => now()->toISOString(),
            ]
        ];

        Cache::forever('banners', $banners);
    }
}