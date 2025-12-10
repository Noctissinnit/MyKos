@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1>Kamar di {{ $kos->nama }}</h1>
        <p class="text-muted">Pilih kamar yang Anda inginkan untuk disewa</p>
    </div>

    @if($kamars->isEmpty())
        <div class="alert alert-info">Belum ada kamar terdaftar di kos ini.</div>
    @else
        <div class="row g-4">
            @foreach($kamars as $kamar)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <!-- Foto Kamar -->
                    @if($kamar->primaryPhoto)
                        <img src="{{ asset('storage/' . $kamar->primaryPhoto->photo_path) }}" class="card-img-top" alt="Kamar {{ $kamar->nomor }}" style="height: 250px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">Kamar {{ $kamar->nomor }}</h5>
                        @if($kamar->nama_kamar)
                            <p class="text-muted small">{{ $kamar->nama_kamar }}</p>
                        @endif

                        <div class="mb-3">
                            <span class="badge bg-primary">{{ ucfirst($kamar->kelas) }}</span>
                            @if($kamar->status == 'kosong')
                                <span class="badge bg-success">Kosong</span>
                            @else
                                <span class="badge bg-danger">Terisi</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <h6 class="text-primary">Rp{{ number_format($kamar->harga, 0, ',', '.') }}/bulan</h6>
                        </div>

                        <!-- Fasilitas -->
                        @if($kamar->facilities()->count() > 0)
                        <div class="mb-3">
                            <h6 class="small fw-bold">Fasilitas:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($kamar->facilities()->take(4) as $facility)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-check-circle"></i> {{ $facility->nama_fasilitas }}
                                    </span>
                                @endforeach
                                @if($kamar->facilities()->count() > 4)
                                    <span class="badge bg-light text-dark">
                                        +{{ $kamar->facilities()->count() - 4 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Status Penghuni -->
                        @if($kamar->status != 'kosong' && $kamar->penghuni)
                        <div class="alert alert-warning alert-sm py-2 px-2 small mb-3">
                            <i class="bi bi-info-circle"></i>
                            <strong>Terisi sampai:</strong><br>
                            {{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_keluar)->format('d M Y') }}
                        </div>
                        @endif

                        <!-- Action -->
                        @if($kamar->status == 'kosong')
                            <a href="{{ route('user.rental_requests.create_kamar', [$kos, $kamar]) }}" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-check-circle"></i> Pesan Sekarang
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                <i class="bi bi-x-circle"></i> Tidak Tersedia
                            </button>
                        @endif

                        <!-- View Details -->
                        <button class="btn btn-outline-secondary btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#kamarModal{{ $kamar->id }}">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Kamar -->
            <div class="modal fade" id="kamarModal{{ $kamar->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Kamar {{ $kamar->nomor }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Carousel Foto -->
                            @if($kamar->photos()->count() > 0)
                            <div id="carousel{{ $kamar->id }}" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($kamar->photos as $idx => $photo)
                                    <div class="carousel-item @if($idx === 0) active @endif">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}" class="d-block w-100" alt="Foto {{ $idx + 1 }}" style="height: 350px; object-fit: cover;">
                                        @if($photo->is_primary)
                                            <span class="position-absolute top-0 start-50 translate-middle-x badge bg-warning mt-2">Foto Utama</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @if($kamar->photos()->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $kamar->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $kamar->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                                @endif
                            </div>
                            @endif

                            <h6>Informasi Kamar</h6>
                            <ul class="list-unstyled">
                                <li><strong>Nomor:</strong> {{ $kamar->nomor }}</li>
                                <li><strong>Nama:</strong> {{ $kamar->nama_kamar ?? '-' }}</li>
                                <li><strong>Kelas:</strong> {{ ucfirst($kamar->kelas) }}</li>
                                <li><strong>Harga:</strong> Rp{{ number_format($kamar->harga, 0, ',', '.') }}/bulan</li>
                                <li><strong>Status:</strong> 
                                    @if($kamar->status == 'kosong')
                                        <span class="badge bg-success">Kosong</span>
                                    @else
                                        <span class="badge bg-danger">Terisi</span>
                                    @endif
                                </li>
                                @if($kamar->deskripsi)
                                <li><strong>Deskripsi:</strong> {{ $kamar->deskripsi }}</li>
                                @endif
                            </ul>

                            @if($kamar->facilities()->count() > 0)
                            <h6 class="mt-3">Fasilitas Kamar:</h6>
                            <div class="row g-2">
                                @foreach($kamar->facilities as $facility)
                                <div class="col-auto">
                                    <span class="badge bg-info">
                                        <i class="bi bi-check-circle"></i> {{ $facility->nama_fasilitas }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            @if($kamar->status == 'kosong')
                                <a href="{{ route('user.rental_requests.create_kamar', [$kos, $kamar]) }}" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Pesan Kamar
                                </a>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('user.kos.room_types', $kos) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
