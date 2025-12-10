@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row align-items-center">
        {{-- Left Content --}}
        <div class="col-md-6 mb-5 mb-md-0">
            <h1 class="display-4 fw-bold text-dark lh-base">
                Temukan Kos Nyaman <br> 
                <span class="text-primary">Dengan Mudah dan Cepat</span>
            </h1>

            <p class="lead text-muted mt-3">
                Cari kos terdekat, lihat fasilitas lengkap, dan lakukan pemesanan secara aman hanya dalam beberapa klik.
            </p>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="{{ route('user.kos.index') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                    <i class="bi bi-search me-2"></i>Cari Kos Sekarang
                </a>

                @auth
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-dark btn-lg px-4">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg px-4">
                        <i class="bi bi-person-circle me-2"></i>Masuk / Daftar
                    </a>
                @endauth
            </div>

            <div class="mt-4">
                <ul class="list-unstyled">
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
        </div>

        {{-- Right Illustration / Card --}}
        <div class="col-md-6">
            <div class="position-relative">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4" 
                         style="background: radial-gradient(circle at top right, rgba(59,130,246,0.25), rgba(59,130,246,0.05));">
                        
                        <div class="text-center py-5">
                        

                            <h3 class="fw-semibold">Cari Kamar Impianmu</h3>
                            <p class="text-muted mx-auto" style="max-width: 320px;">
                                Jelajahi berbagai tipe kamar, lihat foto detail, dan ajukan sewa dalam satu platform sederhana.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Floating Mini Card --}}
                <div class="shadow rounded-3 p-3 bg-white position-absolute" 
                     style="bottom:-20px; right: -10px; width: 200px;">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-geo-alt-fill fs-3 text-danger"></i>
                        </div>
                        <div>
                            <small class="text-muted">Tersedia di berbagai kota</small>
                            <p class="fw-semibold mb-0">Lokasi Strategis</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
