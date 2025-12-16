<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContentManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Get current content settings
        $content = [
            'landing_title' => Cache::get('landing_title', 'Temukan Kos Impian Anda'),
            'landing_subtitle' => Cache::get('landing_subtitle', 'Platform terpercaya untuk mencari dan menyewa kos di seluruh Indonesia'),
            'landing_image' => Cache::get('landing_image', '/img/logomykos.png'),
            'about_content' => Cache::get('about_content', 'MyKos adalah platform digital yang menghubungkan pencari kos dengan pemilik kos secara efisien dan transparan.'),
            'contact_email' => Cache::get('contact_email', 'support@mykos.com'),
            'contact_phone' => Cache::get('contact_phone', '+62 812-3456-7890'),
            'social_facebook' => Cache::get('social_facebook', ''),
            'social_instagram' => Cache::get('social_instagram', ''),
            'social_twitter' => Cache::get('social_twitter', ''),
            'footer_text' => Cache::get('footer_text', '© 2025 MyKos. All rights reserved.'),
            'banners' => $this->getBanners(),
        ];

        return view('admin.content.index', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'landing_title' => 'required|string|max:255',
            'landing_subtitle' => 'required|string|max:500',
            'landing_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_content' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'social_facebook' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'footer_text' => 'required|string|max:255',
        ]);

        // Handle landing image upload
        if ($request->hasFile('landing_image')) {
            $oldImage = Cache::get('landing_image');
            if ($oldImage && $oldImage !== '/img/logomykos.png' && file_exists(public_path(str_replace('/img/', '', $oldImage)))) {
                unlink(public_path(str_replace('/img/', '', $oldImage)));
            }

            $file = $request->file('landing_image');
            $filename = 'landing_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $filename);

            Cache::forever('landing_image', '/img/' . $filename);
        }

        // Update cache with new content
        Cache::forever('landing_title', $request->landing_title);
        Cache::forever('landing_subtitle', $request->landing_subtitle);
        Cache::forever('about_content', $request->about_content);
        Cache::forever('contact_email', $request->contact_email);
        Cache::forever('contact_phone', $request->contact_phone);
        Cache::forever('social_facebook', $request->social_facebook);
        Cache::forever('social_instagram', $request->social_instagram);
        Cache::forever('social_twitter', $request->social_twitter);
        Cache::forever('footer_text', $request->footer_text);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui.');
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banners = $this->getBanners();
        $banners[] = [
            'id' => uniqid(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'link' => $request->link,
            'is_active' => $request->is_active ? $request->is_active : true,
            'created_at' => now()->toISOString(),
        ];

        Cache::forever('banners', $banners);

        return redirect()->back()->with('success', 'Banner berhasil ditambahkan.');
    }

    public function updateBanner(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $banners = $this->getBanners();
        $bannerIndex = collect($banners)->search(function ($banner) use ($id) {
            return $banner['id'] === $id;
        });

        if ($bannerIndex === false) {
            return redirect()->back()->with('error', 'Banner tidak ditemukan.');
        }

        $imagePath = $banners[$bannerIndex]['image'];
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath && \Storage::disk('public')->exists($imagePath)) {
                \Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banners[$bannerIndex] = array_merge($banners[$bannerIndex], [
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'link' => $request->link,
            'is_active' => $request->is_active ? $request->is_active : true,
            'updated_at' => now()->toISOString(),
        ]);

        Cache::forever('banners', $banners);

        return redirect()->back()->with('success', 'Banner berhasil diperbarui.');
    }

    public function deleteBanner($id)
    {
        $banners = $this->getBanners();
        $bannerIndex = collect($banners)->search(function ($banner) use ($id) {
            return $banner['id'] === $id;
        });

        if ($bannerIndex === false) {
            return redirect()->back()->with('error', 'Banner tidak ditemukan.');
        }

        $banner = $banners[$bannerIndex];

        // Delete image file if exists
        if ($banner['image'] && \Storage::disk('public')->exists($banner['image'])) {
            \Storage::disk('public')->delete($banner['image']);
        }

        // Remove banner from array
        unset($banners[$bannerIndex]);
        $banners = array_values($banners);

        Cache::forever('banners', $banners);

        return redirect()->back()->with('success', 'Banner berhasil dihapus.');
    }

    private function getBanners()
    {
        return Cache::get('banners', []);
    }
}