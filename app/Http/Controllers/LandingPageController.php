<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Promo;
use App\Models\Sewa;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $promo = Promo::where('status', true)
        ->whereDate('tanggal_mulai', '<=', now())
        ->whereDate('tanggal_selesai', '>=', now())
        ->get();

        $kendaraan = Kendaraan::take(8)->get();
        return view('welcome', compact('promo','kendaraan'));
    }

    public function daftarKendaraan(Request $request)
{
    $jenis = $request->input('jenis');
    $merk = $request->input('merk');
    $merks = Kendaraan::select('merk')
                ->distinct()
                ->pluck('merk', 'merk');

    $query = Kendaraan::query();

    if ($jenis) {
        $query->where('jenis', $jenis);
    }

    if ($merk) {
        $query->where('merk', $merk);
    }

    $kendaraans = $query->get();

    return view('daftar_kendaraan', compact('kendaraans', 'merks'));
}



    public function detailKendaraan($id)
    {
        $kendaraan = Kendaraan::find($id);
        return view('detail_kendaraan', ['kendaraan' => $kendaraan]);
    }
}
