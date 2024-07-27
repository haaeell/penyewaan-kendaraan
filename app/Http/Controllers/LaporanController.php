<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $query = Sewa::where('status', 'selesai')
                     ->whereYear('tanggal_mulai', $tahun)
                     ->whereMonth('tanggal_mulai', $bulan);

        $laporan = $query->get();

        $totalPendapatan = $query->sum('total_harga');

        return view('admin.laporan.index', compact('laporan', 'bulan', 'tahun', 'totalPendapatan'));
    }

    public function cetakPDF(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $query = Sewa::where('status', 'selesai')
                     ->whereYear('tanggal_mulai', $tahun)
                     ->whereMonth('tanggal_mulai', $bulan);

        $laporan = $query->get();
        $totalPendapatan = $query->sum('total_harga');

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporan', 'bulan', 'tahun', 'totalPendapatan'))
        ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-pemesanan-' . $bulan . '-' . $tahun . '.pdf');
    }

    
}
