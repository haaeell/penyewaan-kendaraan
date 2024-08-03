<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;
    protected $table = 'sewa';

    protected $fillable = [
        'wisatawan_id',
        'kendaraan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status',
        'jenis_pembayaran_id',
        'kode_sewa',
        'metode_pickup',
        'lokasi_pickup',
        'bukti_pembayaran',
        'diskon',
        'harga_setelah_diskon'  ,
        'kode_promo',
        'tanggal_selesai_baru',
        'harga_tambahan',
        'bukti_pembayaran_tambahan'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class);
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class);
    }
}
