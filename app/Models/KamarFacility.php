<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarFacility extends Model
{
    use HasFactory;

    protected $fillable = ['kamar_id', 'nama_fasilitas'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
