@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Riwayat Pembayaran</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($payments->isEmpty())
        <div class="alert alert-info">Belum ada pembayaran.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kamar</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Tanggal Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->penghuni->kamar->nomor ?? '-' }}</td>
                        <td>Rp{{ number_format($p->jumlah,0,',','.') }}</td>
                        <td>{{ ucfirst($p->metode) }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') }}</td>
                        <td>{{ ucfirst($p->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
