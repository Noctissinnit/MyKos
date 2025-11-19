@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <h1>Edit Tipe Kamar</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pemilik.room_types.update', $roomType) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $roomType->nama) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $roomType->kapasitas) }}" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga (per bulan)</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga', $roomType->harga) }}" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $roomType->deskripsi) }}</textarea>
        </div>

        <button class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
