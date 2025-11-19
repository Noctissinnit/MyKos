@extends('layouts.ownerkos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Kos Anda</h3>
    <a href="{{ route('pemilik.kos.create') }}" class="btn btn-primary">+ Tambah Kos</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($kosList->isEmpty())
    <div class="alert alert-info">Belum ada data kos yang ditambahkan.</div>
@else
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nama Kos</th>
            <th>Alamat</th>
            <th>Jumlah Kamar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kosList as $index => $kos)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kos->nama }}</td>
            <td>{{ $kos->alamat }}</td>
            <td>{{ $kos->kamars->count() }}</td>
            <td>
                <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn btn-sm btn-info">Lihat Kamar</a>
                <a href="{{ route('pemilik.kos.edit', $kos->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('pemilik.kos.destroy', $kos->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus kos ini?')" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
