<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'penghuni_id', 'rental_request_id', 'jumlah', 'tanggal_bayar', 'metode', 'status', 'bukti', 'verified'
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }

    public function rentalRequest()
    {
        return $this->belongsTo(\App\Models\RentalRequest::class);
    }

    public function getKosNameAttribute()
    {
        if ($this->rentalRequest?->kos) {
            return $this->rentalRequest->kos->nama;
        }

        return $this->penghuni?->kamar?->kos?->nama ?? '-';
    }

    public function getKamarNomorAttribute()
    {
        return $this->penghuni?->kamar?->nomor ?? '-';
    }

}
