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
    
    .kamar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    
    .kamar-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    
    .kamar-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .kamar-image {
        height: 200px;
        width: 100%;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .kamar-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .kamar-image-placeholder {
        color: #9ca3af;
        font-size: 48px;
    }
    
    .kamar-content {
        padding: 20px;
    }
    
    .kamar-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .kamar-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 12px;
    }
    
    .kamar-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
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
    
    .badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }
    
    .kamar-price {
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
    
    .occupancy-notice {
        background-color: #fef3c7;
        color: #92400e;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        margin-bottom: 12px;
    }
    
    .kamar-actions {
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
    
    .btn-secondary {
        background-color: #6b7280;
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
    
    .btn-secondary:hover {
        background-color: #4b5563;
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
        width: 100%;
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
    <a href="{{ route('user.kos.index', $kos) }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Kembali ke Kos
    </a>

    {{-- Jika tidak ada kamar --}}
    @if($kamars->isEmpty())
        <div class="empty-state">
            <i class="bi bi-building"></i>
            <div style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">Belum ada kamar tersedia</div>
            <div>Kamar di kos ini akan segera ditambahkan</div>
        </div>
    @else
        {{-- Daftar Kamar --}}
        <div class="kamar-grid">
            @foreach($kamars as $kamar)
                <div class="kamar-card">
                    {{-- FOTO --}}
                    @if($kamar->primaryPhoto)
                        <div class="kamar-image">
                            <img src="{{ asset('storage/' . $kamar->primaryPhoto->photo_path) }}" alt="Kamar {{ $kamar->nomor }}">
                        </div>
                    @else
                        <div class="kamar-image">
                            <div class="kamar-image-placeholder">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                    @endif

                    <div class="kamar-content">
                        <div class="kamar-title">Kamar {{ $kamar->nomor }}</div>
                        <div class="kamar-subtitle">{{ $kamar->nama_kamar ?? 'Tanpa nama' }}</div>

                        {{-- BADGE --}}
                        <div class="kamar-badges">
                            <span class="badge badge-primary">{{ ucfirst($kamar->kelas) }}</span>
                            @if($kamar->status == 'kosong')
                                <span class="badge badge-success">Kosong</span>
                            @else
                                <span class="badge badge-danger">Terisi</span>
                            @endif
                        </div>

                        {{-- HARGA --}}
                        <div class="kamar-price">
                            Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bulan
                        </div>

                        {{-- FASILITAS --}}
                        @if($kamar->facilities()->exists())
                            <div class="facility-list">
                                <h6>Fasilitas</h6>
                                <div>
                                    @foreach($kamar->facilities()->take(4) as $facility)
                                        <span class="facility-item">
                                            <i class="bi bi-check-circle"></i> {{ $facility->nama_fasilitas }}
                                        </span>
                                    @endforeach
                                    @if($kamar->facilities()->count() > 4)
                                        <span class="facility-item">
                                            +{{ $kamar->facilities()->count() - 4 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- PENGHUNI --}}
                        @if($kamar->status != 'kosong' && $kamar->penghuni)
                            <div class="occupancy-notice">
                                <i class="bi bi-info-circle" style="margin-right: 4px;"></i>
                                Terisi sampai: <strong>{{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_keluar)->format('d M Y') }}</strong>
                            </div>
                        @endif

                        {{-- ACTION --}}
                        @if($kamar->status == 'kosong')
                            <div class="kamar-actions">
                                <a href="{{ route('user.rental_requests.create_kamar', [$kos, $kamar]) }}" class="btn-primary-custom">
                                    <i class="bi bi-check-circle"></i> Pesan
                                </a>
                                <button class="btn-outline-custom" onclick="toggleDetail({{ $kamar->id }})">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                            </div>
                        @else
                            <button class="btn-secondary" disabled style="cursor: not-allowed;">
                                <i class="bi bi-x-circle"></i> Tidak Tersedia
                            </button>
                        @endif

                        {{-- DETAIL BOX --}}
                        @if($kamar->status == 'kosong')
                            <div id="detail-{{ $kamar->id }}" class="detail-section">
                                <h6>Detail Kamar</h6>
                                <p style="margin: 0; font-size: 13px; color: #6b7280;">
                                    <strong>Kelas:</strong> {{ ucfirst($kamar->kelas) }}<br>
                                    <strong>Deskripsi:</strong> {{ $kamar->deskripsi ?? '-' }}
                                </p>
                                @if($kamar->photos->count() > 0)
                                    <div class="detail-images">
                                        @foreach($kamar->photos->take(4) as $photo)
                                            <img src="{{ asset('storage/'.$photo->photo_path) }}" class="detail-image" alt="Foto kamar">
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
    let box = document.getElementById("detail-" + id);
    box.style.display = box.style.display === "none" ? "block" : "none";
}
</script>

@endsection
        background: #3D63A9;
        border: none;
        border-radius: 12px;
        font-size: 13px;
    }

    .btn-outline-custom {
        border-radius: 12px;
        font-size: 13px;
        border-color: #dcdcdc;
    }

    .badge-soft {
        background: #eef2ff;
        color: #3D63A9;
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 600;
    }

    .detail-box {
        background: #f5f7fa;
        border-radius: 14px;
        padding: 12px;
        margin-top: 10px;
    }

    .detail-img {
        height: 80px;
        width: 110px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>

<div class="container py-4" style="max-width:1250px;">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="page-title">Kamar di {{ $kos->nama }}</h1>
        <p class="page-subtitle">Pilih kamar yang sesuai kebutuhanmu</p>
    </div>

    {{-- Jika tidak ada kamar --}}
    @if($kamars->isEmpty())
        <div class="alert alert-info">Belum ada kamar terdaftar di kos ini.</div>
    @else

    {{-- Daftar Kamar --}}
    <div class="row g-4">
        @foreach($kamars as $kamar)
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="kamar-card">

                {{-- FOTO --}}
                @if($kamar->primaryPhoto)
                    <img src="{{ asset('storage/' . $kamar->primaryPhoto->photo_path) }}" class="kamar-img">
                @else
                    <div class="kamar-img-placeholder">
                        <i class="bi bi-building fs-1 text-secondary"></i>
                    </div>
                @endif

                <div class="p-3">

                    <h5 class="fw-bold mb-1">Kamar {{ $kamar->nomor }}</h5>
                    <p class="text-muted small">{{ $kamar->nama_kamar ?? 'Tanpa nama' }}</p>

                    {{-- BADGE --}}
                    <div class="d-flex gap-2 my-2">
                        <span class="badge-soft">{{ ucfirst($kamar->kelas) }}</span>

                        @if($kamar->status == 'kosong')
                            <span class="badge bg-success">Kosong</span>
                        @else
                            <span class="badge bg-danger">Terisi</span>
                        @endif
                    </div>

                    {{-- HARGA --}}
                    <h6 class="text-primary fw-bold mb-3">
                        Rp{{ number_format($kamar->harga, 0, ',', '.') }}/bulan
                    </h6>

                    {{-- FASILITAS --}}
                    @if($kamar->facilities()->exists())
                        <h6 class="small fw-bold">Fasilitas</h6>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @foreach($kamar->facilities()->take(4) as $facility)
                                <span class="badge bg-light text-dark small">
                                    <i class="bi bi-check-circle"></i> {{ $facility->nama_fasilitas }}
                                </span>
                            @endforeach

                            @if($kamar->facilities()->count() > 4)
                                <span class="badge bg-light text-dark small">
                                    +{{ $kamar->facilities()->count() - 4 }} lainnya
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- PENGHUNI --}}
                    @if($kamar->status != 'kosong' && $kamar->penghuni)
                        <div class="alert alert-warning py-2 small">
                            <i class="bi bi-info-circle"></i> Terisi sampai:
                            <strong>{{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_keluar)->format('d M Y') }}</strong>
                        </div>
                    @endif

                    {{-- ACTION --}}
                    @if($kamar->status == 'kosong')
                        <a href="{{ route('user.rental_requests.create_kamar', [$kos, $kamar]) }}"
                            class="btn btn-primary-custom btn-sm w-100 mb-2">
                            <i class="bi bi-check-circle"></i> Pesan
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm w-100 mb-2" disabled>
                            <i class="bi bi-x-circle"></i> Tidak Tersedia
                        </button>
                    @endif

                    {{-- SHOW/HIDE DETAIL --}}
                    <button
                        class="btn btn-outline-custom btn-sm w-100"
                        onclick="toggleDetail({{ $kamar->id }})">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </button>

                    {{-- DETAIL BOX --}}
                    <div id="detail-{{ $kamar->id }}" class="detail-box" style="display:none;">
                        <h6 class="fw-bold">Detail Kamar</h6>

                        <p class="small mb-1">Kelas: {{ ucfirst($kamar->kelas) }}</p>
                        <p class="small">Deskripsi: {{ $kamar->deskripsi ?? '-' }}</p>

                        @if($kamar->photos->count() > 0)
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @foreach($kamar->photos->take(3) as $photo)
                                <img src="{{ asset('storage/'.$photo->photo_path) }}"
                                     class="detail-img">
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('user.kos.index', $kos) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

</div>

<script>
function toggleDetail(id) {
    let box = document.getElementById("detail-" + id);
    box.style.display = box.style.display === "none" ? "block" : "none";
}
</script>

@endsection
