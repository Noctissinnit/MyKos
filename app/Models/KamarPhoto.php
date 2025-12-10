<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['kamar_id', 'photo_path', 'is_primary'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
