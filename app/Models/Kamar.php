<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'kos_id', 'nomor', 'nama_kamar', 'kelas', 'harga', 'status', 'deskripsi', 'penghuni_id'
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function penghuni()
    {
        return $this->hasOne(Penghuni::class);
    }

    public function photos()
    {
        return $this->hasMany(KamarPhoto::class);
    }

    public function facilities()
    {
        return $this->hasMany(KamarFacility::class);
    }

    public function primaryPhoto()
    {
        return $this->hasOne(KamarPhoto::class)->where('is_primary', true);
    }
}