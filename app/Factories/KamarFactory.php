<?php

namespace App\Factories;

use App\Models\Kamar;
use App\Models\Kos;
use App\Models\RoomType;

class KamarFactory
{
    /**
     * Create a Kamar for a Kos using data from a RoomType and optional overrides.
     *
     * @param  Kos  $kos
     * @param  RoomType  $roomType
     * @param  array  $attributes
     * @return Kamar
     */
    public function createFromRoomType(Kos $kos, RoomType $roomType, array $attributes = []): Kamar
    {
        $data = array_merge([
            'nomor' => $attributes['nomor'] ?? null,
            'room_type_id' => $roomType->id,
            'kelas' => $roomType->nama,
            'harga' => $roomType->harga,
            'status' => $attributes['status'] ?? 'kosong',
            'nama_kamar' => $attributes['nama_kamar'] ?? null,
            'deskripsi' => $attributes['deskripsi'] ?? null,
        ], $attributes);

        return $kos->kamars()->create($data);
    }
}
