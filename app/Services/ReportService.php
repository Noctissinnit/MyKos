<?php

namespace App\Services;

use App\Models\Pembayaran;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * Get payments between two dates (inclusive)
     * @return Collection|Pembayaran[]
     */
    public function paymentsBetween(string $start, string $end)
    {
        return Pembayaran::whereBetween('tanggal_bayar', [$start, $end])
            ->with(['rentalRequest.kos', 'penghuni.kamar.kos'])
            ->orderByDesc('tanggal_bayar')
            ->get();
    }

    /**
     * Total collected (status = lunas) between dates
     */
    public function totalCollectedBetween(string $start, string $end): float
    {
        return (float) Pembayaran::whereBetween('tanggal_bayar', [$start, $end])->where('status', 'lunas')->sum('jumlah');
    }

    /**
     * Group totals by kos (returns array of [kos_id, nama, total])
     */
    public function totalsByKos(string $start, string $end): array
    {
        $payments = $this->paymentsBetween($start, $end);

        $grouped = [];

        foreach ($payments as $p) {
            $kos = null;
            if ($p->rentalRequest && $p->rentalRequest->kos) {
                $kos = $p->rentalRequest->kos;
            } elseif ($p->penghuni && $p->penghuni->kamar && $p->penghuni->kamar->kos) {
                $kos = $p->penghuni->kamar->kos;
            }

            $kosId = $kos ? $kos->id : 0;
            $kosName = $kos ? $kos->nama : 'Tidak terkait';

            if (!isset($grouped[$kosId])) {
                $grouped[$kosId] = ['kos_id' => $kosId, 'nama' => $kosName, 'total' => 0.0];
            }

            if ($p->status === 'lunas') {
                $grouped[$kosId]['total'] += (float)$p->jumlah;
            }
        }

        // reindex
        return array_values($grouped);
    }
}
