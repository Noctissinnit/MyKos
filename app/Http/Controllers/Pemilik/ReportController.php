<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected $reports;

    public function __construct(ReportService $reports)
    {
        $this->middleware(['auth', 'notbanned', 'role:pemilik']);
        $this->reports = $reports;
    }

    public function finance(Request $request)
    {
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end = $request->input('end_date', now()->endOfMonth()->toDateString());

        $payments = $this->reports->paymentsBetween($start, $end);
        $total = $this->reports->totalCollectedBetween($start, $end);
        $byKos = $this->reports->totalsByKos($start, $end);

        // filter by pemilik's kos only
        $pemilikKosIds = \App\Models\Kos::where('user_id', auth()->id())->pluck('id')->toArray();
        $byKos = array_values(array_filter($byKos, function($k) use ($pemilikKosIds) {
            return in_array($k['kos_id'], $pemilikKosIds);
        }));

        return view('pemilik.reports.finance', compact('payments', 'total', 'byKos', 'start', 'end'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end = $request->input('end_date', now()->endOfMonth()->toDateString());
        $payments = $this->reports->paymentsBetween($start, $end);

        $pemilikKosIds = \App\Models\Kos::where('user_id', auth()->id())->pluck('id')->toArray();

        $response = new StreamedResponse(function() use ($payments, $pemilikKosIds) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Tanggal', 'Kos', 'Kamar', 'Jumlah', 'Metode', 'Status']);
            foreach ($payments as $p) {
                $kosName = '-';
                $kamarNo = '-';
                $kosId = 0;
                if ($p->rentalRequest && $p->rentalRequest->kos) {
                    $kosName = $p->rentalRequest->kos->nama;
                    $kosId = $p->rentalRequest->kos->id;
                } elseif ($p->penghuni && $p->penghuni->kamar && $p->penghuni->kamar->kos) {
                    $kosName = $p->penghuni->kamar->kos->nama;
                    $kamarNo = $p->penghuni->kamar->nomor;
                    $kosId = $p->penghuni->kamar->kos->id;
                }

                if (!in_array($kosId, $pemilikKosIds)) {
                    continue;
                }

                fputcsv($out, [$p->tanggal_bayar, $kosName, $kamarNo, $p->jumlah, $p->metode, $p->status]);
            }
            fclose($out);
        });

        $filename = "finance_{$start}_to_{$end}.csv";
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }

   public function transaksi()
    {
        $pemilikKosIds = Kos::where('user_id', auth()->id())->pluck('id');

        // Semua pembayaran dari penghuni yang kamar-nya berada di kos milik user
        $pembayarans = Pembayaran::with('penghuni.user', 'penghuni.kamar')
            ->whereHas('penghuni.kamar', function ($q) use ($pemilikKosIds) {
                $q->whereIn('kos_id', $pemilikKosIds);
            })
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view('pemilik.reports.transaksi', compact('pembayarans'));
    }

}
