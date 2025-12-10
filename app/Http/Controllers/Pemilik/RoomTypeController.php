<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Kos;

class RoomTypeController extends Controller
{
    public function index($kos_id = null)
    {
        // Jika tidak ada kos_id, ambil dari request atau pilih kos pertama
        if (!$kos_id) {
            $kos_id = request('kos_id');
        }

        if (!$kos_id) {
            $kos = Kos::where('user_id', auth()->id())->firstOrFail();
            $kos_id = $kos->id;
        } else {
            $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        }

        // Ambil semua kos milik pemilik untuk dropdown
        $kosList = Kos::where('user_id', auth()->id())->get();
        $roomTypes = RoomType::where('kos_id', $kos->id)->get();
        return view('pemilik.room_types.index', compact('roomTypes', 'kos', 'kosList'));
    }

    public function create($kos_id = null)
    {
        // Jika tidak ada kos_id, ambil dari request atau pilih kos pertama
        if (!$kos_id) {
            $kos_id = request('kos_id');
        }

        if (!$kos_id) {
            $kos = Kos::where('user_id', auth()->id())->firstOrFail();
            $kos_id = $kos->id;
        } else {
            $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        }

        $kosList = Kos::where('user_id', auth()->id())->get();
        return view('pemilik.room_types.create', compact('kos', 'kosList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        // Verify bahwa pemilik adalah owner dari kos ini
        $kos = Kos::where('user_id', auth()->id())->findOrFail($data['kos_id']);

        RoomType::create($data);

        return redirect()->route('pemilik.room_types.index', $data['kos_id'])->with('success', 'Tipe kamar berhasil dibuat.');
    }

    public function edit(RoomType $roomType)
    {
        $this->authorizeOwnership($roomType);
        $kos = $roomType->kos;
        $kosList = Kos::where('user_id', auth()->id())->get();
        return view('pemilik.room_types.edit', compact('roomType', 'kos', 'kosList'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $this->authorizeOwnership($roomType);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $roomType->update($data);

        return redirect()->route('pemilik.room_types.index', $roomType->kos_id)->with('success', 'Tipe kamar diperbarui.');
    }

    public function destroy(RoomType $roomType)
    {
        $this->authorizeOwnership($roomType);
        $kos_id = $roomType->kos_id;
        $roomType->delete();
        return redirect()->route('pemilik.room_types.index', $kos_id)->with('success', 'Tipe kamar dihapus.');
    }

    protected function authorizeOwnership(RoomType $roomType)
    {
        $kos = Kos::where('user_id', auth()->id())->firstOrFail();
        if ($roomType->kos_id !== $kos->id) {
            abort(403);
        }
    }
}
