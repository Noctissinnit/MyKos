@extends('layouts.ownerkos')

@section('content')
<div class="col-md-6 mx-auto">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Edit Kamar untuk {{ $kos->nama }}</h4>

            <form action="{{ route('pemilik.kamar.update', [$kos->id, $kamar->id]) }}" method="POST">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label>Nomor Kamar</label>
                    <input type="text" name="nomor" class="form-control" value="{{ old('nomor', $kamar->nomor) }}" required>
                </div>

                <div class="mb-3">
                    <label>Nama Kamar (opsional)</label>
                    <input type="text" name="nama_kamar" class="form-control" value="{{ old('nama_kamar', $kamar->nama_kamar) }}">
                </div>

                <div class="mb-3">
                    <label>Kelas Kamar</label>
                    <select name="kelas" class="form-select" required>
                        <option value="ekonomi" {{ old('kelas', $kamar->kelas) == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                        <option value="standar" {{ old('kelas', $kamar->kelas) == 'standar' ? 'selected' : '' }}>Standar</option>
                        <option value="premium" {{ old('kelas', $kamar->kelas) == 'premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Harga (per bulan)</label>
                    <input type="number" name="harga" class="form-control" value="{{ old('harga', $kamar->harga) }}" required>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="kosong" {{ old('status', $kamar->status) == 'kosong' ? 'selected' : '' }}>Kosong</option>
                        <option value="terisi" {{ old('status', $kamar->status) == 'terisi' ? 'selected' : '' }}>Terisi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
