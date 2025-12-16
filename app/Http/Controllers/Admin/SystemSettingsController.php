<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SystemSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Get current settings from config or cache
        $settings = [
            'app_name' => config('app.name', 'MyKos'),
            'app_description' => Cache::get('app_description', 'Sistem Manajemen Kos Online'),
            'app_email' => config('mail.from.address', 'noreply@example.com'),
            'maintenance_mode' => app()->isDownForMaintenance(),
            'timezone' => config('app.timezone', 'Asia/Jakarta'),
            'locale' => config('app.locale', 'id'),
            'payment_methods' => Cache::get('payment_methods', ['transfer', 'cash']),
            'commission_rate' => Cache::get('commission_rate', 5), // 5%
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'required|string|max:500',
            'app_email' => 'required|email',
            'timezone' => 'required|string',
            'locale' => 'required|string',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'payment_methods' => 'array',
        ]);

        // Update cache with new settings
        Cache::forever('app_description', $request->app_description);
        Cache::forever('commission_rate', $request->commission_rate);
        Cache::forever('payment_methods', $request->payment_methods ? $request->payment_methods : ['transfer', 'cash']);

        // Update config cache if needed
        // Note: Some settings might require config file updates

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }

    public function toggleMaintenance(Request $request)
    {
        if (app()->isDownForMaintenance()) {
            // Turn off maintenance mode
            Artisan::call('up');
            $message = 'Mode maintenance telah dinonaktifkan.';
        } else {
            // Turn on maintenance mode
            Artisan::call('down', [
                '--secret' => $request->secret ? $request->secret : null,
                '--message' => $request->message ? $request->message : 'Sistem sedang dalam maintenance.',
            ]);
            $message = 'Mode maintenance telah diaktifkan.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function clearCache()
    {
        // Clear various caches
        Cache::flush();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return redirect()->back()->with('success', 'Cache sistem berhasil dibersihkan.');
    }

    public function backupDatabase()
    {
        // This would require additional package like spatie/laravel-backup
        // For now, just return a message
        return redirect()->back()->with('info', 'Fitur backup database akan segera tersedia. Silakan gunakan phpMyAdmin atau mysqldump untuk backup manual.');
    }
}