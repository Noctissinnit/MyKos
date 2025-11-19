<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kos;
use App\Models\RoomType;
use App\Models\RentalRequest;
use App\Models\Pembayaran;

class RentalRequestController extends Controller
{
    public function index()
    {
        // show available kos (approved)
        $kosList = Kos::where('status', 'approved')->with('roomTypes')->get();
        return view('user.kos.index', compact('kosList'));
    }

    public function roomTypes(Kos $kos)
    {
        $roomTypes = $kos->roomTypes()->get();
        return view('user.kos.room_types', compact('kos', 'roomTypes'));
    }

    // show kamars for a kos to users
    public function kamars(Kos $kos)
    {
        $kamars = $kos->kamars()->with('penghuni')->get();
        return view('user.kos.kamars', compact('kos', 'kamars'));
    }

    public function create(Request $request, Kos $kos, RoomType $roomType)
    {
        return view('user.rental_requests.create', compact('kos', 'roomType'));
    }

    // show booking form for a specific kamar
    public function createForKamar(Kos $kos, \App\Models\Kamar $kamar)
    {
        return view('user.rental_requests.create_for_kamar', compact('kos', 'kamar'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_type_id' => 'nullable|exists:room_types,id',
            'kamar_id' => 'nullable|exists:kamars,id',
            'kos_id' => 'required|exists:kos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'message' => 'nullable|string',
        ]);

        // require at least one of room_type_id or kamar_id
        if (empty($data['room_type_id']) && empty($data['kamar_id'])) {
            return back()->withErrors(['room_type_id' => 'Pilih tipe kamar atau langsung pilih kamar untuk dipesan.'])->withInput();
        }

        // jika user memilih kamar spesifik, cek ketersediaan (tidak boleh ada rental yang sudah disetujui dan overlap)
        if (!empty($data['kamar_id'])) {
            $start = $data['start_date'];
            $end = $data['end_date'];

            $conflict = RentalRequest::where('kamar_id', $data['kamar_id'])
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
                return back()->withErrors(['kamar_id' => 'Maaf, kamar ini sudah tidak tersedia pada rentang tanggal yang dipilih. Silakan pilih kamar lain atau pilih tipe kamar.'])->withInput();
            }
        }

        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        $rental = RentalRequest::create($data);

        return redirect()->route('user.rental_requests.index')->with('success', 'Permintaan sewa dikirim. Silakan tunggu konfirmasi dari pemilik.');
    }

    public function myRequests()
    {
        $requests = RentalRequest::where('user_id', auth()->id())->with('kos', 'roomType', 'payments')->get();
        return view('user.rental_requests.index', compact('requests'));
    }
}
