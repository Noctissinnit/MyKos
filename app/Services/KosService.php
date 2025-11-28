<?php

namespace App\Services;

use App\Models\Kos;

class KosService
{
    private static $instance = null;

    
    private function __construct() {}

 
    public static function getInstance(): KosService
    {
        if (self::$instance === null) {
            self::$instance = new KosService();
        }
        return self::$instance;
    }

    public function getAllByOwner(int $ownerId)
    {
        return Kos::where('user_id', $ownerId)->get();
    }

    public function createKos(array $data, int $ownerId)
    {
        return Kos::create([
            'user_id'   => $ownerId,
            'nama_kos'  => $data['nama_kos'],
            'alamat'    => $data['alamat'],
            'deskripsi' => $data['deskripsi'] ?? null,
        ]);
    }

    public function findByOwner(int $ownerId, int $kosId)
    {
        return Kos::where('user_id', $ownerId)->findOrFail($kosId);
    }

    public function updateKos(int $ownerId, int $kosId, array $data)
    {
        $kos = $this->findByOwner($ownerId, $kosId);
        $kos->update($data);
        return $kos;
    }

    public function deleteKos(int $ownerId, int $kosId)
    {
        $kos = $this->findByOwner($ownerId, $kosId);
        return $kos->delete();
    }
}
