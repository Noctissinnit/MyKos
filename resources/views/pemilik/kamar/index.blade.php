@extends('layouts.ownerkos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Kamar - {{ $kos->nama }}</h3>
    <a href="{{ route('pemilik.kamar.create', $kos->id) }}" class="btn btn-primary">+ Tambah Kamar</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($kamars->isEmpty())
    <div class="alert alert-info">Belum ada kamar yang ditambahkan untuk kos ini.</div>
@else
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nomor Kamar</th>
            <th>Kelas</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Penghuni</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kamars as $index => $kamar)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kamar->nomor }}</td>
            <td>{{ ucfirst($kamar->kelas) }}</td>
            <td>Rp{{ number_format($kamar->harga, 0, ',', '.') }}</td>
            <td>
                @if($kamar->status == 'kosong')
                    <span class="badge bg-success">Kosong</span>
                @else
                    <span class="badge bg-danger">Terisi</span>
                @endif
            </td>
            <td>
                @if($kamar->penghuni)
                    <div>{{ $kamar->penghuni->name }}</div>
                    <small class="text-muted">
                        Periode: {{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_masuk)->format('d M Y') }} - {{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_keluar)->format('d M Y') }}
                    </small>
                @else
                    -
                @endif
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('pemilik.kamar.edit', [$kos->id, $kamar->id]) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('pemilik.kamar.edit.photos', [$kos->id, $kamar->id]) }}" class="btn btn-info">Foto</a>
                    <a href="{{ route('pemilik.kamar.edit.facilities', [$kos->id, $kamar->id]) }}" class="btn btn-outline-info">Fasilitas</a>
                    <form action="{{ route('pemilik.kamar.destroy', [$kos->id, $kamar->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus kamar ini?')" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
