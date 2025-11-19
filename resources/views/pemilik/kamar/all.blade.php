@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Semua Kamar Saya</h3>
    </div>

    @if($kamars->isEmpty())
        <div class="alert alert-info">Belum ada kamar yang terdaftar.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Kos</th>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Penghuni</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kamars as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $k->kos->nama ?? '-' }}</td>
                        <td>{{ $k->nomor }}</td>
                        <td>{{ $k->nama_kamar ?? '-' }}</td>
                        <td>{{ ucfirst($k->kelas) }}</td>
                        <td>Rp{{ number_format($k->harga,0,',','.') }}</td>
                        <td>
                            @if($k->status == 'kosong')
                                <span class="badge bg-success">Kosong</span>
                            @else
                                <span class="badge bg-danger">Terisi</span>
                            @endif
                        </td>
                        <td>
                            @if($k->penghuni)
                                <div>{{ $k->penghuni->name }}</div>
                                <small class="text-muted">
                                    Periode: {{ \Carbon\Carbon::parse($k->penghuni->tanggal_masuk)->format('d M Y') }} - {{ \Carbon\Carbon::parse($k->penghuni->tanggal_keluar)->format('d M Y') }}
                                </small>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pemilik.kamar.edit', [$k->kos_id, $k->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
