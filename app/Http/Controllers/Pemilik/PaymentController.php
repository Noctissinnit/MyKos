<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'notbanned', 'role:pemilik']);
    }

    // verify a payment uploaded for a rental request
    public function verify(Request $request, Pembayaran $pembayaran)
    {
        // ensure the payment belongs to a rental request and that the rental's kos
        // is owned by the current pemilik
        if (! $pembayaran->rentalRequest || ! $pembayaran->rentalRequest->kos || $pembayaran->rentalRequest->kos->user_id !== auth()->id()) {
            abort(403);
        }

        $pembayaran->status = 'lunas';
        $pembayaran->verified = true;
        $pembayaran->tanggal_bayar = now()->toDateString();
        $pembayaran->save();

        return back()->with('success', 'Pembayaran diverifikasi. Silakan lanjutkan proses persetujuan kamar.');
    }
}
