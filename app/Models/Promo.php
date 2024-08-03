<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    protected $fillable = ['kode', 'deskripsi', 'jenis', 'nilai', 'gambar', 'tanggal_mulai', 'tanggal_selesai', 'status'];

    public function isValid()
    {
        $today = now()->toDateString();
        return $this->status && $this->tanggal_mulai <= $today && $this->tanggal_selesai >= $today;
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}
