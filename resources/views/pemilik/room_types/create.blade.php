@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <h1>Buat Tipe Kamar untuk {{ $kos->nama }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pemilik.room_types.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kos_id" value="{{ $kos->id }}">
        
        <div class="mb-3">
            <label class="form-label">Pilih Kos (jika ingin mengubah)</label>
            <select name="kos_id" class="form-select">
                @foreach($kosList as $k)
                    <option value="{{ $k->id }}" @if($k->id === $kos->id) selected @endif>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', 1) }}" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga (per bulan)</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga', 0) }}" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('pemilik.room_types.index', $kos->id) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
