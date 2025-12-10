<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Kos;
use App\Models\RoomType;
use App\Models\KamarPhoto;
use App\Models\KamarFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Factories\KamarFactory;

class KamarController extends Controller
{
    protected KamarFactory $factory;

    public function __construct(KamarFactory $factory)
    {
        $this->factory = $factory;
    }

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

        $roomTypes = RoomType::where('kos_id', $kos->id)->get(); 

        return view('pemilik.kamar.create', compact('kos', 'roomTypes'));
    }

    public function store(Request $request, $kos_id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);

        $request->validate([
            'nomor'        => 'required|string|max:50',
            'room_type_id' => 'required|exists:room_types,id',
        ]);

        $roomType = RoomType::findOrFail($request->room_type_id);

        // METODE FACTORY NYA INI JANLUP
        $this->factory->createFromRoomType($kos, $roomType, $request->only([
            'nomor', 'nama_kamar', 'deskripsi'
        ]));

        return redirect()
            ->route('pemilik.kamar.index', $kos_id)
            ->with('success', 'Kamar berhasil ditambahkan!');
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

    // Manage Photos
    public function editPhotos($kos_id, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);
        $photos = $kamar->photos()->get();
        return view('pemilik.kamar.photos', compact('kos', 'kamar', 'photos'));
    }

    public function uploadPhoto(Request $request, $kos_id, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('kamar/' . $kamar->id, 'public');

            // Jika belum ada primary photo, jadikan ini primary
            $isPrimary = $kamar->photos()->count() === 0;

            KamarPhoto::create([
                'kamar_id' => $kamar->id,
                'photo_path' => $path,
                'is_primary' => $isPrimary,
            ]);

            return redirect()->route('pemilik.kamar.edit.photos', [$kos_id, $id])
                ->with('success', 'Foto berhasil ditambahkan!');
        }

        return redirect()->route('pemilik.kamar.edit.photos', [$kos_id, $id])
            ->with('error', 'Gagal menambahkan foto!');
    }

    public function deletePhoto($kos_id, $id, $photo_id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);
        $photo = $kamar->photos()->findOrFail($photo_id);

        // Hapus file dari storage
        if (Storage::disk('public')->exists($photo->photo_path)) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $photo->delete();

        return redirect()->route('pemilik.kamar.edit.photos', [$kos_id, $id])
            ->with('success', 'Foto berhasil dihapus!');
    }

    public function setPrimaryPhoto($kos_id, $id, $photo_id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);
        $photo = $kamar->photos()->findOrFail($photo_id);

        // Reset semua primary
        $kamar->photos()->update(['is_primary' => false]);

        // Set photo ini sebagai primary
        $photo->update(['is_primary' => true]);

        return redirect()->route('pemilik.kamar.edit.photos', [$kos_id, $id])
            ->with('success', 'Foto utama berhasil diubah!');
    }

    // Manage Facilities
    public function editFacilities($kos_id, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);
        $facilities = $kamar->facilities()->get();
        return view('pemilik.kamar.facilities', compact('kos', 'kamar', 'facilities'));
    }

    public function addFacility(Request $request, $kos_id, $id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);

        $request->validate([
            'nama_fasilitas' => 'required|string|max:100',
        ]);

        KamarFacility::create([
            'kamar_id' => $kamar->id,
            'nama_fasilitas' => $request->nama_fasilitas,
        ]);

        return redirect()->route('pemilik.kamar.edit.facilities', [$kos_id, $id])
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    public function deleteFacility($kos_id, $id, $facility_id)
    {
        $kos = Kos::where('user_id', auth()->id())->findOrFail($kos_id);
        $kamar = $kos->kamars()->findOrFail($id);
        $facility = $kamar->facilities()->findOrFail($facility_id);

        $facility->delete();

        return redirect()->route('pemilik.kamar.edit.facilities', [$kos_id, $id])
            ->with('success', 'Fasilitas berhasil dihapus!');
    }
}
