@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Tipe Kamar - {{ $kos->nama }}</h3>
        <a href="{{ route('pemilik.kos.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali ke Kos</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($kosList) > 1)
    <div class="mb-4">
        <label class="form-label fw-bold">Pilih Kos Lain:</label>
        <div class="btn-group" role="group">
            @foreach($kosList as $k)
                <a href="{{ route('pemilik.room_types.index', $k->id) }}" 
                   class="btn btn-sm btn-outline-primary @if($k->id === $kos->id) active @endif">
                    {{ $k->nama }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <a href="{{ route('pemilik.room_types.create', $kos->id) }}" class="btn btn-primary mb-3">Buat Tipe Kamar</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kapasitas</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roomTypes as $type)
                <tr>
                    <td>{{ $type->nama }}</td>
                    <td>{{ $type->kapasitas }}</td>
                    <td>Rp {{ number_format($type->harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('pemilik.room_types.edit', $type) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('pemilik.room_types.destroy', $type) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus tipe kamar?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada tipe kamar untuk kos ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
