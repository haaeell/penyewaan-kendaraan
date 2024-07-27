<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function daftarKendaraan(Request $request)
    {
        $jenis = $request->input('jenis');
        $merk = $request->input('merk');
    
        // Ambil daftar merk unik
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
