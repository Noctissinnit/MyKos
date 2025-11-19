@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kamar di {{ $kos->nama }}</h1>

    @if($kamars->isEmpty())
        <div class="alert alert-info">Belum ada kamar terdaftar di kos ini.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kamars as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $k->nomor }}</td>
                        <td>{{ $k->nama_kamar ?? '-' }}</td>
                        <td>{{ ucfirst($k->kelas) }}</td>
                        <td>Rp{{ number_format($k->harga,0,',','.') }}</td>
                        <td>
                            @if($k->status == 'kosong')
                                <span class="badge bg-success">Kosong</span>
                                <a href="{{ route('user.rental_requests.create_kamar', [$kos, $k]) }}" class="btn btn-sm btn-primary ms-2">Pesan</a>
                            @else
                                <div><span class="badge bg-danger">Terisi</span></div>
                                @if($k->penghuni)
                                    <small class="text-muted">
                                        Periode: {{ \Carbon\Carbon::parse($k->penghuni->tanggal_masuk)->format('d M Y') }} - {{ \Carbon\Carbon::parse($k->penghuni->tanggal_keluar)->format('d M Y') }}
                                    </small>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('user.kos.room_types', $kos) }}" class="btn btn-secondary">Kembali ke Tipe Kamar</a>
</div>
@endsection
