@extends('layouts.ownerkos')

@section('content')
<div class="col-md-6 mx-auto">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Tambah Kos Baru</h4>

            <form action="{{ route('pemilik.kos.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Kos</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('pemilik.kos.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
