@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Kos</h1>

    <div class="row">
        @foreach($kosList as $kos)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $kos->nama }}</h5>
                        <p class="card-text">{{ Str::limit($kos->deskripsi, 100) }}</p>
                        <a href="{{ route('user.kos.room_types', $kos) }}" class="btn btn-primary">Lihat Tipe Kamar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
