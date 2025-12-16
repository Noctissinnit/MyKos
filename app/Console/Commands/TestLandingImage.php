<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestLandingImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:landing-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test landing image functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Landing Image Functionality');
        $this->line('=====================================');

        // Check current cache value
        $currentImage = \Cache::get('landing_image', '/img/logomykos.png');
        $this->info("Current landing image cache: $currentImage");

        // Check if file exists
        if ($currentImage !== '/img/logomykos.png') {
            $filePath = storage_path('app/public/' . str_replace('/storage/', '', $currentImage));
            if (file_exists($filePath)) {
                $this->info("✅ File exists: $filePath");
                $this->info("File size: " . filesize($filePath) . " bytes");
            } else {
                $this->error("❌ File does not exist: $filePath");
            }
        }

        // Check storage link
        $storageLink = public_path('storage');
        if (is_link($storageLink)) {
            $this->info("✅ Storage link exists: $storageLink");
        } else {
            $this->error("❌ Storage link does not exist: $storageLink");
        }

        // Test asset URL generation
        $assetUrl = asset($currentImage);
        $this->info("Asset URL: $assetUrl");

        $this->line('');
        $this->info('Test completed!');
    }
}
