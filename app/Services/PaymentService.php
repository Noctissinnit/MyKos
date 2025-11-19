<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Penghuni;
use Carbon\Carbon;

class PaymentService
{
    /**
     * Create a payment record for a penghuni. This simulates payment creation.
     *
     * @param Penghuni $penghuni
     * @param float $jumlah
     * @param string $metode
     * @param bool $markPaid
     * @return Pembayaran
     */
    public function createPayment(Penghuni $penghuni, float $jumlah, string $metode = 'transfer', bool $markPaid = false): Pembayaran
    {
        $p = Pembayaran::create([
            'penghuni_id' => $penghuni->id,
            'jumlah' => $jumlah,
            'tanggal_bayar' => Carbon::now()->toDateString(),
            'metode' => $metode,
            'status' => $markPaid ? 'lunas' : 'pending',
        ]);

        return $p;
    }

    /**
     * Mark a payment as paid.
     */
    public function markAsPaid(Pembayaran $pembayaran): Pembayaran
    {
        $pembayaran->status = 'lunas';
        $pembayaran->tanggal_bayar = Carbon::now()->toDateString();
        $pembayaran->save();
        return $pembayaran;
    }
}
