<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Kos;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index($kos_id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamars = $kos->kamars;
        return view('pemilik.kamar.index', compact('kos', 'kamars'));
    }

    // show all kamars across all kos owned by the authenticated pemilik
    public function all()
    {
        $kosList = Kos::where('user_id', auth()->id())->pluck('id');
        $kamars = Kamar::whereIn('kos_id', $kosList)->with('kos', 'penghuni')->get();
        return view('pemilik.kamar.all', compact('kamars'));
    }

    public function create($kos_id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        return view('pemilik.kamar.create', compact('kos'));
    }

    public function store(Request $request, $kos_id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);

        $request->validate([
            'nomor'      => 'required|string|max:50',
            'nama_kamar' => 'nullable|string|max:255',
            'kelas'      => 'required|in:ekonomi,standar,premium',
            'harga'      => 'required|numeric|min:0',
            'status'     => 'nullable|in:kosong,terisi',
            'deskripsi'  => 'nullable|string',
        ]);

        $kos->kamars()->create($request->only(['nomor', 'nama_kamar', 'kelas', 'harga', 'status', 'deskripsi']));

        return redirect()->route('pemilik.kamar.index', $kos_id)->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit($kos_id, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);
        return view('pemilik.kamar.edit', compact('kos', 'kamar'));
    }

    public function update(Request $request, $kos_id, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);

        $request->validate([
            'nomor'      => 'required|string|max:50',
            'nama_kamar' => 'nullable|string|max:255',
            'kelas'      => 'required|in:ekonomi,standar,premium',
            'harga'      => 'required|numeric|min:0',
            'status'     => 'required|in:kosong,terisi',
            'deskripsi'  => 'nullable|string',
        ]);

        $kamar->update($request->only(['nomor', 'nama_kamar', 'kelas', 'harga', 'status', 'deskripsi']));

        return redirect()->route('pemilik.kamar.index', $kos_id)->with('success', 'Kamar berhasil diperbarui!');
    }

    public function destroy($kos_id, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);
        $kamar->delete();

        return redirect()->route('pemilik.kamar.index', $kos_id)->with('success', 'Kamar berhasil dihapus!');
    }
}
