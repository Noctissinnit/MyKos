@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <h1>Tipe Kamar</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pemilik.room_types.create') }}" class="btn btn-primary mb-3">Buat Tipe Kamar</a>

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
                    <td>{{ number_format($type->harga, 0, ',', '.') }}</td>
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
                <tr><td colspan="4">Belum ada tipe kamar.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
