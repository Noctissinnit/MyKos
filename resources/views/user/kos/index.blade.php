@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .page-header .left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }
    
    .search-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .search-box {
        padding: 10px 16px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: white;
        width: 280px;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .search-box:focus {
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
        outline: none;
    }
    
    .btn-search {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-search:hover {
        background-color: #3a5a8f;
        transform: translateY(-1px);
    }
    
    .kos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    
    .kos-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    
    .kos-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .kos-image {
        height: 180px;
        width: 100%;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .kos-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .kos-image-placeholder {
        color: #9ca3af;
        font-size: 48px;
    }
    
    .kos-content {
        padding: 20px;
    }
    
    .kos-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .kos-desc {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }
    
    .kos-actions {
        display: flex;
        gap: 8px;
    }
    
    .btn-primary-custom {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        justify-content: center;
    }
    
    .btn-primary-custom:hover {
        background-color: #3a5a8f;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-outline-custom {
        background-color: white;
        color: #4a6fa5;
        border: 1px solid #4a6fa5;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        justify-content: center;
    }
    
    .btn-outline-custom:hover {
        background-color: #4a6fa5;
        color: white;
        transform: translateY(-1px);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 16px;
        display: block;
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    {{-- Header --}}
    <div class="page-header">
        <div class="left">
            <h1><i class="bi bi-buildings" style="margin-right: 12px;"></i>Daftar Kos</h1>
            <p>Temukan kos sesuai kebutuhanmu – lihat tipe kamar dan pesan mudah</p>
        </div>

        {{-- Search --}}
        <div class="search-container">
            <form method="GET" action="{{ url()->current() }}" style="display: flex; gap: 8px;">
                <input name="q" value="{{ request('q') }}" 
                    class="search-box" type="search" placeholder="Cari nama atau lokasi">
                <button class="btn-search" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- List Kos --}}
    @if($kosList->isEmpty())
        <div class="empty-state">
            <i class="bi bi-building"></i>
            <div style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">Belum ada kos yang ditemukan</div>
            <div>Coba ubah kata kunci pencarian atau kembali nanti</div>
        </div>
    @else
        <div class="kos-grid">
            @foreach($kosList as $kos)
                <div class="kos-card">
                    {{-- Image --}}
                    <div class="kos-image">
                        @if($kos->photos && $kos->photos->count() > 0)
                            <img src="{{ asset('storage/' . $kos->photos->first()->photo_path) }}" alt="{{ $kos->nama }}">
                        @else
                            <div class="kos-image-placeholder">
                                <i class="bi bi-building"></i>
                            </div>
                        @endif
                    </div>

                    <div class="kos-content">
                        <div class="kos-title">{{ $kos->nama }}</div>
                        <div class="kos-desc">
                            {{ Str::limit($kos->deskripsi ?? 'Lokasi tidak tersedia', 80) }}
                        </div>

                        <div class="kos-actions">
                            <a href="{{ route('user.kos.room_types', $kos) }}" class="btn-primary-custom">
                                <i class="bi bi-eye"></i> Lihat Tipe
                            </a>
                            <a href="{{ route('user.kos.room_types', $kos) }}" class="btn-outline-custom">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
