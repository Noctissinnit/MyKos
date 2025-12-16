<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penghuni;
use App\Models\RentalRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
         $this->middleware(['auth', 'role:user']);
    }

    public function index()
    {
           $userId = auth()->id();

        $pendingCount = RentalRequest::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $activeCount = Penghuni::where('user_id', $userId)
            ->where('status', 'aktif')
            ->count();

        $penghuniIds = Penghuni::where('user_id', $userId)->pluck('id');

        $duePayments = Pembayaran::whereIn('penghuni_id', $penghuniIds)
            ->where('verified', false)
            ->count();

        $recentRequests = RentalRequest::where('user_id', $userId)
            ->with(['kos', 'kamar', 'roomType'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($r) {
                $r->statusColor = $r->status === 'pending'
                    ? 'warning text-dark'
                    : ($r->status === 'approved' ? 'success' : 'danger');

                return $r;
            });

        $recentPayments = Pembayaran::whereIn('penghuni_id', $penghuniIds)
            ->latest('tanggal_bayar')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'pendingCount',
            'activeCount',
            'duePayments',
            'recentRequests',
            'recentPayments'
        ));
    }
}
