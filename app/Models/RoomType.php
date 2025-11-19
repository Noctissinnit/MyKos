<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = ['kos_id', 'nama', 'kapasitas', 'harga', 'deskripsi'];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function rentalRequests()
    {
        return $this->hasMany(RentalRequest::class);
    }
}
