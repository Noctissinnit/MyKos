@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Selamat datang, {{ auth()->user()->name }}</h2>
            <p class="text-muted mb-0">Dashboard pengguna — kelola permintaan sewa dan pembayaran Anda.</p>
        </div>
        <div>
            <a href="{{ route('user.kos.index') }}" class="btn btn-primary">Jelajahi Kos</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Permintaan Sewa Pending</h6>
                    @php
                        $pendingCount = \App\Models\RentalRequest::where('user_id', auth()->id())->where('status', 'pending')->count();
                    @endphp
                    <h3 class="mb-0 text-warning">{{ $pendingCount }}</h3>
                    <a href="{{ route('user.rental_requests.index') }}" class="btn btn-sm btn-outline-warning mt-3">Lihat Permintaan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Sewa Aktif</h6>
                    @php
                        $activeCount = \App\Models\Penghuni::where('user_id', auth()->id())->where('status', 'aktif')->count();
                    @endphp
                    <h3 class="mb-0 text-success">{{ $activeCount }}</h3>
                    <a href="{{ route('user.pembayarans.index') }}" class="btn btn-sm btn-outline-success mt-3">Lihat Pembayaran</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Tagihan Menunggu</h6>
                    @php
                        $penghuniIds = \App\Models\Penghuni::where('user_id', auth()->id())->pluck('id');
                        $duePayments = \App\Models\Pembayaran::whereIn('penghuni_id', $penghuniIds)->where('verified', false)->count();
                    @endphp
                    <h3 class="mb-0 text-danger">{{ $duePayments }}</h3>
                    <a href="{{ route('user.pembayarans.index') }}" class="btn btn-sm btn-outline-danger mt-3">Bayar Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <strong>Permintaan Sewa Terbaru</strong>
                </div>
                <div class="card-body">
                    @php
                        $recentRequests = \App\Models\RentalRequest::where('user_id', auth()->id())->with('kos', 'kamar', 'roomType')->orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    @if($recentRequests->isEmpty())
                        <p class="text-muted">Belum ada permintaan sewa.</p>
                    @else
                        <ul class="list-group">
                            @foreach($recentRequests as $r)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $r->kos->nama ?? '-' }}</strong><br>
                                        <small class="text-muted">
                                            @if($r->kamar) Kamar {{ $r->kamar->nomor }} @elseif($r->roomType) {{ $r->roomType->nama }} @endif
                                            • {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                        </small>
                                    </div>
                                    <div>
                                        <span class="badge bg-{{ $r->status === 'pending' ? 'warning text-dark' : ($r->status === 'approved' ? 'success' : 'danger') }}">{{ ucfirst($r->status) }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <strong>Transaksi Terakhir</strong>
                </div>
                <div class="card-body">
                    @php
                        $penghuni = \App\Models\Penghuni::where('user_id', auth()->id())->with('kamar.kos')->first();
                        $recentPayments = [];
                        if ($penghuni) {
                            $recentPayments = \App\Models\Pembayaran::where('penghuni_id', $penghuni->id)->orderBy('tanggal_bayar', 'desc')->take(5)->get();
                        }
                    @endphp

                    @if(empty($recentPayments) || count($recentPayments) === 0)
                        <p class="text-muted">Belum ada transaksi.</p>
                    @else
                        <ul class="list-group">
                            @foreach($recentPayments as $p)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</strong><br>
                                        <small class="text-muted">{{ $p->tanggal_bayar ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') : '-' }}</small>
                                    </div>
                                    <div>
                                        @if($p->verified)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
