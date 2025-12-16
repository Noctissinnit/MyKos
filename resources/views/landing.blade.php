@extends('layouts.app')

@section('content')
<style>
    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
    }
    .hero-sub {
        font-size: 2rem;
        font-weight: 700;
        color: #4a6fa5;
    }

    .btn-primary-custom {
        background-color: #4a6fa5;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        background-color: #3a5a8f;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(74, 111, 165, 0.3);
    }

    .btn-secondary-custom {
        background-color: white;
        color: #4a6fa5;
        border: 2px solid #4a6fa5;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background-color: #4a6fa5;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(74, 111, 165, 0.3);
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.2rem; }
        .hero-sub { font-size: 1.6rem; }
    }
</style>

<div class="container py-5">
    <div class="row align-items-center">

        {{-- LEFT SECTION --}}
        <div class="col-md-6 mb-5 mb-md-0">

            <h1 class="hero-title text-dark">
                {{ \Illuminate\Support\Facades\Cache::get('landing_title', 'Temukan Kos Nyaman') }} <br>
                <span class="hero-sub">{{ \Illuminate\Support\Facades\Cache::get('landing_subtitle', 'Dengan Mudah dan Cepat') }}</span>
            </h1>

            <p class="text-muted mt-3" style="font-size: 1.1rem;">
                {{ \Illuminate\Support\Facades\Cache::get('about_content', 'Cari kos terdekat, lihat fasilitas lengkap, dan lakukan pemesanan secara aman hanya dalam beberapa klik.') }}
            </p>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="{{ route('user.kos.index') }}" class="btn btn-lg px-4 shadow-sm btn-primary-custom">
                    <i class="bi bi-search me-2"></i>
                    Cari Kos Sekarang
                </a>

                @auth
                    <a href="{{ route('user.dashboard') }}" class="btn btn-lg px-4 btn-secondary-custom">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-lg px-4 btn-secondary-custom">
                        <i class="bi bi-person-circle me-2"></i> Masuk / Daftar
                    </a>
                @endauth
            </div>

            <ul class="list-unstyled mt-4">
                <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Ribuan kos terverifikasi & aman
                </li>
                <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Fitur pesan dan unggah bukti pembayaran
                </li>
                <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Laporan transaksi khusus pemilik
                </li>
            </ul>

        </div>

        {{-- RIGHT SECTION (ILLUSTRATION) --}}
        <div class="col-md-6 text-center">

            <img src="{{ \Illuminate\Support\Facades\Cache::get('landing_image', '/img/elemen3d.png') }}"
                 alt="Landing Illustration"
                 class="img-fluid"
                 style="max-width: 380px; transform: rotate(20deg);">

        </div>

    </div>
</div>

{{-- BANNER SECTION --}}
@php
    $banners = \Illuminate\Support\Facades\Cache::get('banners', []);
    $activeBanners = array_filter($banners, function($banner) {
        return isset($banner['is_active']) && $banner['is_active'];
    });
@endphp

@if(count($activeBanners) > 0)
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4" style="color: #4a6fa5; font-weight: 700;">Promo & Penawaran Spesial</h2>

            <div class="banner-carousel">
                <div class="row g-4">
                    @foreach($activeBanners as $banner)
                    <div class="col-md-6 col-lg-4">
                        <div class="banner-card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            @if($banner['image'])
                                <img src="{{ asset('storage/' . $banner['image']) }}"
                                     alt="{{ $banner['title'] }}"
                                     class="img-fluid w-100"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div style="height: 200px; background: linear-gradient(135deg, #4a6fa5, #6b82a7); display: flex; align-items: center; justify-content: center; color: white;">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                </div>
                            @endif

                            <div class="p-3">
                                <h5 class="mb-2" style="color: #1f2937; font-weight: 600;">{{ $banner['title'] }}</h5>
                                @if($banner['description'])
                                    <p class="mb-3 text-muted small">{{ Str::limit($banner['description'], 100) }}</p>
                                @endif

                                @if($banner['link'])
                                    <a href="{{ $banner['link'] }}" class="btn btn-primary-custom btn-sm" target="_blank">
                                        <i class="bi bi-arrow-right me-1"></i>Lihat Detail
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- CONTACT SECTION --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <h2 class="mb-4" style="color: #4a6fa5; font-weight: 700;">Hubungi Kami</h2>
            <p class="text-muted mb-4">Ada pertanyaan? Kami siap membantu Anda 24/7</p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-card p-4 text-center" style="border-radius: 12px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <i class="bi bi-envelope" style="font-size: 2rem; color: #4a6fa5; margin-bottom: 1rem;"></i>
                        <h5>Email</h5>
                        <p class="text-muted">{{ \Illuminate\Support\Facades\Cache::get('contact_email', 'support@mykos.com') }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card p-4 text-center" style="border-radius: 12px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <i class="bi bi-telephone" style="font-size: 2rem; color: #4a6fa5; margin-bottom: 1rem;"></i>
                        <h5>Telepon</h5>
                        <p class="text-muted">{{ \Illuminate\Support\Facades\Cache::get('contact_phone', '+62 812-3456-7890') }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card p-4 text-center" style="border-radius: 12px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <i class="bi bi-share" style="font-size: 2rem; color: #4a6fa5; margin-bottom: 1rem;"></i>
                        <h5>Sosial Media</h5>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            @if(\Illuminate\Support\Facades\Cache::get('social_facebook'))
                                <a href="{{ \Illuminate\Support\Facades\Cache::get('social_facebook') }}" target="_blank" style="color: #4a6fa5; font-size: 1.5rem;">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if(\Illuminate\Support\Facades\Cache::get('social_instagram'))
                                <a href="{{ \Illuminate\Support\Facades\Cache::get('social_instagram') }}" target="_blank" style="color: #4a6fa5; font-size: 1.5rem;">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if(\Illuminate\Support\Facades\Cache::get('social_twitter'))
                                <a href="{{ \Illuminate\Support\Facades\Cache::get('social_twitter') }}" target="_blank" style="color: #4a6fa5; font-size: 1.5rem;">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
