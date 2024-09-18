<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'nama', 'jenis', 'type', 'plat_nomor', 'keterangan', 'tahun', 'seating_capacity', 'merk', 'harga'
    ];
    public function getIsRentedAttribute()
    {
        $rental = Sewa::where('kendaraan_id', $this->id)
            ->where('tanggal_selesai', '>=', now())
            ->where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal_selesai', 'desc')
            ->first();

        if ($rental) {
            $tanggalSelesai = Carbon::parse($rental->tanggal_selesai);
            $tanggalSelesai->locale('id'); // Set locale to Indonesian
            return [
                'status' => true,
                'available_at' => $tanggalSelesai->translatedFormat('j F Y') // Use translatedFormat for Indonesian month names
            ];
        }


        return [
            'status' => false,
            'available_at' => null
        ];
    }

    public function sewa()
    {
        return $this->hasMany(Sewa::class, 'kendaraan_id');
    }
}
