<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KosService;

class KosController extends Controller
{
    private KosService $service;

    public function __construct()
    {
        $this->middleware(['auth', 'role:pemilik']);

        // Ambil Insiasi Singletonnya disini
        $this->service = KosService::getInstance();
    }

    public function index()
    {
        $kosList = $this->service->getAllByOwner(auth()->id());
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

        $this->service->createKos($request->all(), auth()->id());

        return redirect()
            ->route('pemilik.kos.index')
            ->with('success', 'Kos berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kos = $this->service->findByOwner(auth()->id(), $id);
        return view('pemilik.kos.edit', compact('kos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kos' => 'required|string|max:255',
            'alamat'   => 'required|string',
            'deskripsi'=> 'nullable|string',
        ]);

        $this->service->updateKos(auth()->id(), $id, $request->only(['nama_kos', 'alamat', 'deskripsi']));

        return redirect()
            ->route('pemilik.kos.index')
            ->with('success', 'Data kos berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->service->deleteKos(auth()->id(), $id);

        return redirect()
            ->route('pemilik.kos.index')
            ->with('success', 'Kos berhasil dihapus!');
    }
}
