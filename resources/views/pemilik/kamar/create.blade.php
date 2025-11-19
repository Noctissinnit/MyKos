@extends('layouts.ownerkos')

@section('content')
<div class="col-md-6 mx-auto">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Tambah Kamar untuk {{ $kos->nama }}</h4>

            <form action="{{ route('pemilik.kamar.store', $kos->id) }}" method="POST">
                @csrf

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
                            <input type="text" name="nomor" class="form-control" value="{{ old('nomor') }}" required>
                        </div>

                <div class="mb-3">
                    <label>Kelas Kamar</label>
                    <select name="kelas" class="form-select" required>
                        <option value="ekonomi">Ekonomi</option>
                        <option value="standar">Standar</option>
                        <option value="premium">Premium</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label>Harga (per bulan)</label>
                    <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required>
                </div>


                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="kosong" {{ old('status') == 'kosong' ? 'selected' : '' }}>Kosong</option>
                        <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
