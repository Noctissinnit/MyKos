@extends('layouts.ownerkos')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">Dashboard Pemilik Kos</h2>

    {{-- STAT CARDS --}}
    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Kamar</h5>
                    <h3>{{ $totalKamar }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <h5 class="card-title">Kamar Terisi</h5>
                    <h3>{{ $kamarTerisi }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    <h5 class="card-title">Kamar Kosong</h5>
                    <h3>{{ $kamarKosong }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-info">
                <div class="card-body">
                    <h5 class="card-title">Penghuni Aktif</h5>
                    <h3>{{ $penghuniAktif }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- PENDAPATAN --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>Pendapatan Bulan Ini</h5>
            <h2 class="text-success">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h2>
        </div>
    </div>

    {{-- RECENT PAYMENT TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Transaksi Terakhir</h5>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Penghuni</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($recentPayments as $p)
                    <tr>
                        <td>{{ $p->penghuni->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $p->tanggal_bayar }}</td>
                        <td>
                            <span class="badge 
                                {{ $p->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Belum ada transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection
