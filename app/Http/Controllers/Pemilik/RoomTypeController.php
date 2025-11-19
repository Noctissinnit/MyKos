<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Kos;

class RoomTypeController extends Controller
{
    public function index()
    {
        $kos = Kos::where('user_id', auth()->id())->firstOrFail();
        $roomTypes = RoomType::where('kos_id', $kos->id)->get();
        return view('pemilik.room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('pemilik.room_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $kos = Kos::where('user_id', auth()->id())->firstOrFail();
        $data['kos_id'] = $kos->id;

        RoomType::create($data);

        return redirect()->route('pemilik.room_types.index')->with('success', 'Tipe kamar berhasil dibuat.');
    }

    public function edit(RoomType $roomType)
    {
        $this->authorizeOwnership($roomType);
        return view('pemilik.room_types.edit', compact('roomType'));
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

        return redirect()->route('pemilik.room_types.index')->with('success', 'Tipe kamar diperbarui.');
    }

    public function destroy(RoomType $roomType)
    {
        $this->authorizeOwnership($roomType);
        $roomType->delete();
        return redirect()->route('pemilik.room_types.index')->with('success', 'Tipe kamar dihapus.');
    }

    protected function authorizeOwnership(RoomType $roomType)
    {
        $kos = Kos::where('user_id', auth()->id())->firstOrFail();
        if ($roomType->kos_id !== $kos->id) {
            abort(403);
        }
    }
}
