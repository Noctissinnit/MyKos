<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kos_id', 'kamar_id', 'room_type_id', 'start_date', 'end_date', 'status', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Pembayaran::class);
    }
}
