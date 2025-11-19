@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tipe Kamar di {{ $kos->nama }}</h1>

    <div class="row">
        @forelse($roomTypes as $type)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $type->nama }} - {{ number_format($type->harga,0,',','.') }} / bulan</h5>
                        <p class="card-text">Kapasitas: {{ $type->kapasitas }}</p>
                        <p class="card-text">{{ Str::limit($type->deskripsi, 100) }}</p>
                        <a href="{{ route('user.rental_requests.create', [$kos, $type]) }}" class="btn btn-primary">Pesan</a>
                        <a href="{{ route('user.kos.kamars', $kos) }}" class="btn btn-outline-secondary ms-2">Lihat Kamar</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">Belum ada tipe kamar.</div>
        @endforelse
    </div>
</div>
@endsection
