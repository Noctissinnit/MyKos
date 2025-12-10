<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemilikController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:pemilik']);
    }

    public function index()
    {
        $kosIds = \App\Models\Kos::where('user_id', auth()->id())->pluck('id');

        // Total kamar
        $totalKamar = \App\Models\Kamar::whereIn('kos_id', $kosIds)->count();
        $kamarTerisi = \App\Models\Penghuni::whereHas('kamar', fn($q) => $q->whereIn('kos_id', $kosIds))->count();
        $kamarKosong = $totalKamar - $kamarTerisi;

        // Penghuni aktif
        $penghuniAktif = \App\Models\Penghuni::whereNull('tanggal_keluar')
            ->whereHas('kamar', fn($q) => $q->whereIn('kos_id', $kosIds))
            ->count();

        // Pendapatan bulan ini
        $pendapatanBulanIni = \App\Models\Pembayaran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->whereHas('penghuni.kamar', fn($q) => $q->whereIn('kos_id', $kosIds))
            ->sum('jumlah');

        // 5 transaksi terakhir
        $recentPayments = \App\Models\Pembayaran::with('penghuni.user', 'penghuni.kamar')
            ->whereHas('penghuni.kamar', fn($q) => $q->whereIn('kos_id', $kosIds))
            ->orderBy('tanggal_bayar', 'desc')
            ->take(5)
            ->get();

        // Permintaan sewa pending
        $pendingRequests = \App\Models\RentalRequest::with('user', 'kos', 'kamar', 'roomType')
            ->whereIn('kos_id', $kosIds)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Total permintaan pending
        $totalPendingRequests = \App\Models\RentalRequest::whereIn('kos_id', $kosIds)
            ->where('status', 'pending')
            ->count();

        // Data semua kos pemilik
        $kosList = \App\Models\Kos::where('user_id', auth()->id())->with('kamars')->get();

        return view('pemilik.dashboard', compact(
            'totalKamar',
            'kamarTerisi',
            'kamarKosong',
            'penghuniAktif',
            'pendapatanBulanIni',
            'recentPayments',
            'pendingRequests',
            'totalPendingRequests',
            'kosList'
        ));
    }
}
