@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <h1>Permintaan Sewa Masuk</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Tipe</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $r)
                <tr>
                    <td>{{ $r->user->name ?? '-' }}</td>
                    <td>{{ $r->roomType->nama ?? '-' }}</td>
                    <td>{{ $r->start_date }} - {{ $r->end_date }}</td>
                    <td>{{ $r->status }}</td>
                    <td>
                        <a href="{{ route('pemilik.rental_requests.show', $r) }}" class="btn btn-sm btn-primary">Lihat</a>
                        <form action="{{ route('pemilik.rental_requests.reject', $r) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button class="btn btn-sm btn-danger">Tolak</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada permintaan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
