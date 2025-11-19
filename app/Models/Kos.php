<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nama', 'alamat', 'deskripsi', 'status'];

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kamars()
    {
        return $this->hasMany(Kamar::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
}
