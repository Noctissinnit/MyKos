<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $payments;

    public function __construct(PaymentService $payments)
    {
        $this->payments = $payments;
        $this->middleware(['auth', 'notbanned', 'role:user']);
    }

    // list payments for current user (via penghuni relation)
    public function index()
    {
        $userId = auth()->id();
        $payments = Pembayaran::whereHas('penghuni', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('penghuni.kamar')->orderByDesc('created_at')->get();

        return view('user.pembayarans.index', compact('payments'));
    }

    // show upload proof form for a rental request
    public function uploadForRentalRequest(\App\Models\RentalRequest $rentalRequest)
    {
        if ($rentalRequest->user_id !== auth()->id()) {
            abort(403);
        }

        // Hitung jumlah pembayaran dari harga kamar (jika ada kamar yang dipilih)
        $jumlah = 0;
        if ($rentalRequest->kamar) {
            $jumlah = $rentalRequest->kamar->harga;
        } elseif ($rentalRequest->roomType) {
            $jumlah = $rentalRequest->roomType->harga;
        }

        return view('user.pembayarans.upload_for_rental', compact('rentalRequest', 'jumlah'));
    }

    // show create form for a penghuni (user must own penghuni)
    public function create(Penghuni $penghuni)
    {
        if ($penghuni->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.pembayarans.create', compact('penghuni'));
    }

    // store payment (simulate)
    public function store(Request $request)
    {
        // support two flows: payment for existing penghuni OR upload proof for rental request
        $data = $request->validate([
            'penghuni_id' => 'sometimes|exists:penghunis,id',
            'rental_request_id' => 'sometimes|exists:rental_requests,id',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|in:transfer,cash',
            'bukti' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pay_now' => 'sometimes|boolean',
        ]);

        $markPaid = !empty($data['pay_now']);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('payments', 'public');
        }

        if (!empty($data['penghuni_id'])) {
            $penghuni = Penghuni::findOrFail($data['penghuni_id']);
            if ($penghuni->user_id !== auth()->id()) {
                abort(403);
            }

            $payment = Pembayaran::create([
                'penghuni_id' => $penghuni->id,
                'jumlah' => $data['jumlah'],
                'tanggal_bayar' => now()->toDateString(),
                'metode' => $data['metode'],
                'status' => $markPaid ? 'lunas' : 'pending',
                'bukti' => $buktiPath,
                'verified' => $markPaid ? true : false,
            ]);

        } elseif (!empty($data['rental_request_id'])) {
            $rental = \App\Models\RentalRequest::findOrFail($data['rental_request_id']);
            if ($rental->user_id !== auth()->id()) {
                abort(403);
            }

            $payment = Pembayaran::create([
                'rental_request_id' => $rental->id,
                'jumlah' => $data['jumlah'],
                'tanggal_bayar' => now()->toDateString(),
                'metode' => $data['metode'],
                'status' => 'pending',
                'bukti' => $buktiPath,
                'verified' => false,
            ]);

        } else {
            return back()->withErrors(['rental_request_id' => 'Tidak ada target pembayaran (penghuni atau ajuan sewa).']);
        }

        return redirect()->route('user.pembayarans.index')->with('success', 'Bukti pembayaran berhasil diunggah. Pemilik akan memverifikasi.');
    }

 

}
