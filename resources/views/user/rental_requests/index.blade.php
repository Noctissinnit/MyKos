@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Permintaan Sewa Saya</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Kos</th>
                <th>Tipe</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $r)
                <tr>
                    <td>{{ $r->kos->nama ?? '-' }}</td>
                    <td>{{ $r->roomType->nama ?? '-' }}</td>
                    <td>{{ $r->start_date }} - {{ $r->end_date }}</td>
                    <td>{{ $r->status }}</td>
                    <td>
                        @if($r->payments->isEmpty())
                            <a href="{{ route('user.rental_requests.upload_proof', $r) }}" class="btn btn-sm btn-primary">Unggah Bukti</a>
                        @else
                            @foreach($r->payments as $p)
                                <div>
                                    <small>{{ ucfirst($p->status) }} @if($p->verified) (Terverifikasi) @endif - Rp{{ number_format($p->jumlah,0,',','.') }}</small>
                                    @if($p->bukti)
                                        <div><a href="{{ asset('storage/' . $p->bukti) }}" target="_blank">Lihat Bukti</a></div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada permintaan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
