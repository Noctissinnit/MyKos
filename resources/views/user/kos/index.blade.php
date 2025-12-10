@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-0">Daftar Kos</h1>
            <p class="text-muted small mb-0">Temukan kos sesuai kebutuhanmu — lihat tipe kamar dan pesan mudah.</p>
        </div>

        <form method="GET" action="{{ url()->current() }}" class="d-flex" role="search">
            <input name="q" value="{{ request('q') }}" class="form-control form-control-sm me-2" type="search" placeholder="Cari nama atau lokasi" aria-label="Search">
            <button class="btn btn-outline-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <div class="row g-3">
        @forelse($kosList as $kos)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="ratio ratio-16x9 bg-light d-flex align-items-center justify-content-center text-white" style="border-top-left-radius:.5rem; border-top-right-radius:.5rem; overflow:hidden; background:linear-gradient(135deg, rgba(37,99,235,0.08), rgba(59,130,246,0.06));">
                        <div class="text-center text-muted">
                            <i class="bi bi-building fs-1"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $kos->nama }}</h5>
                        <p class="text-muted small mb-2">{{ Str::limit($kos->deskripsi, 110) }}</p>

                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('user.kos.room_types', $kos) }}" class="btn btn-primary btn-sm">Lihat Tipe</a>
                            <a href="{{ route('user.kos.room_types', $kos) }}" class="btn btn-outline-secondary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada kos yang ditemukan.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{-- Jika ada paginator dari controller, tampilkan links --}}
        @if(method_exists($kosList, 'links'))
            <div class="d-flex justify-content-center">
                {{ $kosList->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
