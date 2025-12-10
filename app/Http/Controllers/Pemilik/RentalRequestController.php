<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalRequest;
use App\Models\Kos;
use App\Models\Kamar;
use App\Models\Penghuni;

class RentalRequestController extends Controller
{
    // list all rental requests for pemilik's kos
    public function index()
    {
        $kosIds = Kos::where('user_id', auth()->id())->pluck('id');
        $requests = RentalRequest::whereIn('kos_id', $kosIds)
            ->with('user', 'kos', 'kamar', 'roomType')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pemilik.rental_requests.index', compact('requests'));
    }

    // show a single request and available kamars for that room type
    public function show(RentalRequest $rentalRequest)
    {
        // Ensure the authenticated pemilik owns the kos related to this rental request
        if (! $rentalRequest->kos || $rentalRequest->kos->user_id !== auth()->id()) {
            abort(403);
        }

        // available kamars in that kos matching the requested room type (kelas)
        $availableKamars = Kamar::where('kos_id', $rentalRequest->kos_id)
            ->where('status', 'kosong')
            ->get();

        return view('pemilik.rental_requests.show', compact('rentalRequest', 'availableKamars'));
    }

    // approve a request: assign kamar, create penghuni, mark kamar terisi
    public function approve(Request $request, RentalRequest $rentalRequest)
    {
        // Verify ownership of the kos for this rental request
        if (! $rentalRequest->kos || $rentalRequest->kos->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'kamar_id' => 'required|exists:kamars,id',
        ]);

        $kamar = Kamar::where('id', $data['kamar_id'])->where('kos_id', $rentalRequest->kos_id)->where('status', 'kosong')->firstOrFail();

        // double-check availability: past approved rentals might overlap (race-condition protection)
        $start = $rentalRequest->start_date;
        $end = $rentalRequest->end_date;
        $conflict = RentalRequest::where('kamar_id', $kamar->id)
            ->where('status', 'approved')
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function($q2) use ($start, $end) {
                      $q2->where('start_date', '<=', $start)
                         ->where('end_date', '>=', $end);
                  });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['kamar_id' => 'Tidak bisa menyetujui: kamar sudah terpesan pada rentang tanggal tersebut. Silakan pilih kamar lain.']);
        }

        // create penghuni
        $penghuni = Penghuni::create([
            'user_id' => $rentalRequest->user_id,
            'kamar_id' => $kamar->id,
            'tanggal_masuk' => $rentalRequest->start_date,
            'tanggal_keluar' => $rentalRequest->end_date,
            'status' => 'aktif',
        ]);

        // mark kamar as terisi and set penghuni_id if column exists
        $kamar->status = 'terisi';
        if (in_array('penghuni_id', $kamar->getFillable())) {
            $kamar->penghuni_id = $rentalRequest->user_id;
        }
        $kamar->save();

        // update rental request
        $rentalRequest->kamar_id = $kamar->id;
        $rentalRequest->status = 'approved';
        $rentalRequest->save();

        return redirect()->route('pemilik.rental_requests.index')->with('success', 'Permintaan disetujui dan kamar telah ditempati.');
    }

    public function reject(Request $request, RentalRequest $rentalRequest)
    {
        if (! $rentalRequest->kos || $rentalRequest->kos->user_id !== auth()->id()) {
            abort(403);
        }

        $rentalRequest->status = 'rejected';
        $rentalRequest->save();

        return redirect()->route('pemilik.rental_requests.index')->with('success', 'Permintaan ditolak.');
    }
}
