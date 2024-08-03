<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanFoto extends Model
{
    use HasFactory;

    protected $fillable = ['kendaraan_id', 'foto'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
