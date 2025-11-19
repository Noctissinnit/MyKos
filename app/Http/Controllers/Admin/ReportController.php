<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected $reports;

    public function __construct(ReportService $reports)
    {
        $this->middleware(['auth', 'notbanned', 'role:admin']);
        $this->reports = $reports;
    }

    public function finance(Request $request)
    {
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end = $request->input('end_date', now()->endOfMonth()->toDateString());

        $payments = $this->reports->paymentsBetween($start, $end);
        $total = $this->reports->totalCollectedBetween($start, $end);
        $byKos = $this->reports->totalsByKos($start, $end);

        return view('admin.reports.finance', compact('payments', 'total', 'byKos', 'start', 'end'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end = $request->input('end_date', now()->endOfMonth()->toDateString());
        $payments = $this->reports->paymentsBetween($start, $end);

        $response = new StreamedResponse(function() use ($payments) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Tanggal', 'Kos', 'Kamar', 'Jumlah', 'Metode', 'Status']);
            foreach ($payments as $p) {
                $kosName = '-';
                $kamarNo = '-';
                if ($p->rentalRequest && $p->rentalRequest->kos) {
                    $kosName = $p->rentalRequest->kos->nama;
                } elseif ($p->penghuni && $p->penghuni->kamar && $p->penghuni->kamar->kos) {
                    $kosName = $p->penghuni->kamar->kos->nama;
                    $kamarNo = $p->penghuni->kamar->nomor;
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
}
