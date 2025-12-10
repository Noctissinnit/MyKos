@extends('layouts.ownerkos')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Pemilik Kos</h2>
        <a href="{{ route('pemilik.kos.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-building"></i> Kelola Kos
        </a>
    </div>

    {{-- STAT CARDS --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted">Total Kamar</h6>
                            <h3 class="text-primary mb-0">{{ $totalKamar }}</h3>
                        </div>
                        <i class="bi bi-door-closed text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted">Kamar Terisi</h6>
                            <h3 class="text-success mb-0">{{ $kamarTerisi }}</h3>
                        </div>
                        <i class="bi bi-check-circle text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-warning h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted">Kamar Kosong</h6>
                            <h3 class="text-warning mb-0">{{ $kamarKosong }}</h3>
                        </div>
                        <i class="bi bi-exclamation-circle text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-info h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted">Penghuni Aktif</h6>
                            <h3 class="text-info mb-0">{{ $penghuniAktif }}</h3>
                        </div>
                        <i class="bi bi-people text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-4">
        {{-- PENDAPATAN --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-muted mb-3">
                        <i class="bi bi-cash-coin"></i> Pendapatan Bulan Ini
                    </h6>
                    <h2 class="text-success">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h2>
                    <small class="text-muted">{{ now()->format('F Y') }}</small>
                </div>
            </div>
        </div>

        {{-- PENDING REQUESTS --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100 @if($totalPendingRequests > 0) border-warning @endif">
                <div class="card-body">
                    <h6 class="card-title text-muted mb-3">
                        <i class="bi bi-hourglass-split"></i> Permintaan Sewa Pending
                    </h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="text-warning mb-0">{{ $totalPendingRequests }}</h2>
                        @if($totalPendingRequests > 0)
                            <a href="{{ route('pemilik.rental_requests.index') }}" class="btn btn-sm btn-warning">
                                Lihat Semua →
                            </a>
                        @endif
                    </div>
                    <small class="text-muted">Menunggu persetujuan Anda</small>
                </div>
            </div>
        </div>
    </div>

    {{-- PENDING REQUESTS TABLE --}}
    @if($totalPendingRequests > 0)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-clock-history"></i> Permintaan Sewa Terbaru
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pengguna</th>
                        <th>Kos</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pendingRequests as $req)
                    <tr>
                        <td>
                            <strong>{{ $req->user->name ?? '-' }}</strong><br>
                            <small class="text-muted">{{ $req->user->email ?? '-' }}</small>
                        </td>
                        <td>{{ $req->kos->nama ?? '-' }}</td>
                        <td>
                            <small>
                                {{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }} <br>
                                s/d {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">{{ ucfirst($req->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('pemilik.rental_requests.show', $req) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Tidak ada permintaan pending.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- RECENT PAYMENTS TABLE --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-credit-card"></i> Transaksi Pembayaran Terakhir
                </h5>
                <a href="{{ route('pemilik.reports.transactions') }}" class="btn btn-sm btn-outline-secondary">
                    Lihat Semua
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Penghuni</th>
                        <th>Kamar</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($recentPayments as $p)
                    <tr>
                        <td>
                            <strong>{{ $p->penghuni?->user?->name ?? '-' }}</strong><br>
                            <small class="text-muted">{{ $p->penghuni?->kamar?->kos?->nama ?? '-' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                Kamar {{ $p->penghuni?->kamar?->nomor ?? '-' }}
                            </span>
                        </td>
                        <td><strong>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') }}</td>
                        <td>
                            @if($p->verified)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Terverifikasi
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split"></i> Menunggu
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- KOS OVERVIEW --}}
    @if($kosList->count() > 0)
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-buildings"></i> Ringkasan Semua Kos Anda
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Kos</th>
                            <th>Total Kamar</th>
                            <th>Kamar Terisi</th>
                            <th>Kamar Kosong</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($kosList as $kos)
                        @php
                            $totalKosKamar = $kos->kamars->count();
                            $terisiKos = $kos->kamars->filter(function($kamar) {
                                return $kamar->penghuni !== null;
                            })->count();
                            $kosongKos = $totalKosKamar - $terisiKos;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $kos->nama }}</strong><br>
                                <small class="text-muted">{{ $kos->alamat }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $totalKosKamar }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $terisiKos }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ $kosongKos }}</span>
                            </td>
                            <td>
                                @if($kos->status === 'approved')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i> {{ ucfirst($kos->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn btn-sm btn-primary">
                                    Kelola
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection
