@extends('layouts.app')

@section('content')
<style>
    .page-header {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
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
    
    .room-type-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    
    .room-type-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    
    .room-type-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .room-type-image {
        height: 200px;
        width: 100%;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .room-type-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .room-type-image-placeholder {
        color: #9ca3af;
        font-size: 48px;
    }
    
    .room-type-content {
        padding: 20px;
    }
    
    .room-type-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .room-type-desc {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }
    
    .room-type-price {
        font-size: 16px;
        font-weight: 700;
        color: #4a6fa5;
        margin-bottom: 12px;
    }
    
    .facility-list {
        margin-bottom: 16px;
    }
    
    .facility-list h6 {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .facility-item {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background-color: #f3f4f6;
        color: #374151;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 11px;
        margin-right: 4px;
        margin-bottom: 4px;
    }
    
    .badge {
        padding: 4px 8px;
        font-weight: 500;
        font-size: 11px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    .badge-primary {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .room-type-actions {
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
    
    .detail-section {
        background-color: #f9fafb;
        border-radius: 8px;
        padding: 16px;
        margin-top: 12px;
        display: none;
    }
    
    .detail-section h6 {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
    }
    
    .detail-images {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }
    
    .detail-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .back-btn {
        background-color: #6b7280;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 20px;
    }
    
    .back-btn:hover {
        background-color: #4b5563;
        color: white;
        transform: translateY(-2px);
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
    
    .occupancy-notice {
        background-color: #fef3c7;
        color: #92400e;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        margin-bottom: 12px;
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1><i class="bi bi-door-open" style="margin-right: 12px;"></i>Kamar di {{ $kos->nama }}</h1>
            <p>Pilih kamar yang sesuai kebutuhanmu</p>
        </div>
    </div>

    {{-- Back Button --}}
    <a href="{{ route('user.kos.index') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kos
    </a>

    {{-- 🔥 Solusi B: fallback otomatis bila $kamars tidak ada --}}
    @php
        $kamarsCollection = $kamars ?? ($kos->kamars ?? collect());
    @endphp

    @if($kamarsCollection->isEmpty())
        <div class="empty-state">
            <i class="bi bi-building"></i>
            <div style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">Belum ada kamar tersedia</div>
            <div>Kamar di kos ini akan segera ditambahkan</div>
        </div>
    @else
        <div class="room-type-grid">
            @foreach($kamarsCollection as $kamar)
                <div class="room-type-card">
                    {{-- Foto --}}
                    @if($kamar->primaryPhoto)
                        <div class="room-type-image">
                            <img src="{{ asset('storage/' . $kamar->primaryPhoto->photo_path) }}" alt="Kamar {{ $kamar->nomor }}">
                        </div>
                    @else
                        <div class="room-type-image">
                            <div class="room-type-image-placeholder">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                    @endif

                    <div class="room-type-content">
                        {{-- Judul --}}
                        <div class="room-type-title">Kamar {{ $kamar->nomor }}</div>
                        @if($kamar->nama_kamar)
                            <div class="room-type-desc">{{ $kamar->nama_kamar }}</div>
                        @endif

                        {{-- Badge --}}
                        <div style="display: flex; gap: 6px; margin-bottom: 12px;">
                            <span class="badge badge-primary">{{ ucfirst($kamar->kelas) }}</span>
                            @if($kamar->status == 'kosong')
                                <span class="badge" style="background-color: #d1fae5; color: #065f46;">Kosong</span>
                            @else
                                <span class="badge" style="background-color: #fee2e2; color: #dc2626;">Terisi</span>
                            @endif
                        </div>

                        {{-- Harga --}}
                        <div class="room-type-price">
                            Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bulan
                        </div>

                        {{-- Fasilitas --}}
                        @if($kamar->facilities()->count() > 0)
                            <div class="facility-list">
                                <h6>Fasilitas</h6>
                                <div>
                                    @foreach($kamar->facilities()->take(3) as $facility)
                                        <span class="facility-item">
                                            <i class="bi bi-check-circle"></i> {{ $facility->nama_fasilitas }}
                                        </span>
                                    @endforeach
                                    @if($kamar->facilities()->count() > 3)
                                        <span class="facility-item">
                                            +{{ $kamar->facilities()->count() - 3 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Status Penghuni --}}
                        @if($kamar->status != 'kosong' && $kamar->penghuni)
                            <div class="occupancy-notice">
                                <i class="bi bi-info-circle" style="margin-right: 4px;"></i>
                                Terisi sampai: <strong>{{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_keluar)->format('d M Y') }}</strong>
                            </div>
                        @endif

                        {{-- Tombol --}}
                        <div class="room-type-actions">
                            @if($kamar->status == 'kosong')
                                <a href="{{ route('user.rental_requests.create_kamar', [$kos, $kamar]) }}" class="btn-primary-custom">
                                    <i class="bi bi-check-circle"></i> Pesan
                                </a>
                                <button class="btn-outline-custom" onclick="toggleDetail({{ $kamar->id }})">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                            @else
                                <button class="btn-primary-custom" disabled style="cursor: not-allowed; background-color: #6b7280;">
                                    <i class="bi bi-x-circle"></i> Tidak Tersedia
                                </button>
                            @endif
                        </div>

                        {{-- Detail (Show/Hide) --}}
                        @if($kamar->status == 'kosong')
                            <div id="detail-{{ $kamar->id }}" class="detail-section">
                                <h6>Detail Kamar</h6>
                                <p style="margin: 0; font-size: 13px; color: #6b7280;">
                                    <strong>Kelas:</strong> {{ ucfirst($kamar->kelas) }}<br>
                                    <strong>Deskripsi:</strong> {{ $kamar->deskripsi ?? '-' }}
                                </p>
                                @if($kamar->photos->count() > 0)
                                    <div class="detail-images">
                                        @foreach($kamar->photos->take(3) as $p)
                                            <img src="{{ asset('storage/'.$p->photo_path) }}" class="detail-image" alt="Foto kamar">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

<script>
function toggleDetail(id) {
    let box = document.getElementById('detail-' + id);
    box.style.display = (box.style.display === 'none') ? 'block' : 'none';
}
</script>

@endsection
       