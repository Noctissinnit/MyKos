<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use Illuminate\Http\Request;

class KosController extends Controller
{
    public function index()
    {
        $kosList = Kos::where('user_id', auth()->id())->get();
        return view('pemilik.kos.index', compact('kosList'));
    }

    public function create()
    {
        return view('pemilik.kos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kos' => 'required|string|max:255',
            'alamat'   => 'required|string',
            'deskripsi'=> 'nullable|string',
        ]);

        Kos::create([
            'user_id'  => auth()->id(),
            'nama_kos' => $request->nama_kos,
            'alamat'   => $request->alamat,
            'deskripsi'=> $request->deskripsi,
        ]);

        return redirect()->route('pemilik.kos.index')->with('success', 'Kos berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($id);
        return view('pemilik.kos.edit', compact('kos'));
    }

    public function update(Request $request, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'nama_kos' => 'required|string|max:255',
            'alamat'   => 'required|string',
            'deskripsi'=> 'nullable|string',
        ]);

        $kos->update($request->only(['nama_kos', 'alamat', 'deskripsi']));

        return redirect()->route('pemilik.kos.index')->with('success', 'Data kos berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($id);
        $kos->delete();

        return redirect()->route('pemilik.kos.index')->with('success', 'Kos berhasil dihapus!');
    }
}
