<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'nama',
        'foto',
        'jenis',
        'type',
        'plat_nomor',
        'keterangan',
        'tahun',
        'seating_capacity',
        'merk',
        'harga',
    ];
}
