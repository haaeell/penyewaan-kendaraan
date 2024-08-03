<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use App\Models\Kendaraan;
use App\Models\Promo;
use App\Models\Sewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function index()
    {
        $sewas = Sewa::with('wisatawan', 'kendaraan', 'jenisPembayaran')->get();
        return view('admin.sewa.index', compact('sewas'));
    }

    public function create($kendaraan_id)
    {
        $kendaraan = Kendaraan::findOrFail($kendaraan_id);
        $jenisPembayaran = JenisPembayaran::all();
        return view('pesan_kendaraan', compact('kendaraan', 'jenisPembayaran'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'metode_pickup' => 'required|string',
            'jenis_pembayaran' => 'required|exists:jenis_pembayaran,id',
            'lokasi_pickup' => 'nullable|string',
            'kode_promo' => 'nullable|string',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        // Menghitung durasi dalam jam
        $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = \Carbon\Carbon::parse($request->tanggal_selesai);
        $durasiJam = $tanggalMulai->diffInHours($tanggalSelesai);

        $tarifPerHari = $kendaraan->harga;
        $durasiHari = ceil($durasiJam / 24);

        $totalHarga = $durasiHari * $tarifPerHari;

        $diskon = 0;
        if ($request->has('kode_promo') && !empty($request->kode_promo)) {
            $kodePromo = $request->kode_promo;

            $promo = Promo::where('kode', $kodePromo)->first();
            if ($promo) {
                if ($promo->jenis === 'diskon_persen') {
                    $diskon = $totalHarga * ($promo->nilai / 100);
                } elseif ($promo->jenis === 'potongan_harga') {
                    $diskon = $promo->nilai;
                }
            }
        }

        $totalHargaSetelahDiskon = $totalHarga - $diskon;

        Sewa::create([
            'wisatawan_id' => Auth::user()->wisatawan->id,
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_harga' => $totalHarga,
            'status' => 'belum_dibayar',
            'jenis_pembayaran_id' => $request->jenis_pembayaran,
            'kode_sewa' => $this->generateKodeSewa(),
            'metode_pickup' => $request->metode_pickup,
            'lokasi_pickup' => $request->lokasi_pickup,
            'kode_promo' => $request->kode_promo,
            'diskon' => $diskon,
            'harga_setelah_diskon' => $totalHargaSetelahDiskon
        ]);

        // Mengarahkan pengguna ke riwayat sewa dengan pesan sukses
        return redirect()->route('sewa.riwayat')->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function perpanjang(Request $request, $id)
    {
        $request->validate([
            'tanggal_selesai_baru' => 'required|date|after_or_equal:tanggal_selesai',
            'bukti_pembayaran_tambahan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    
        $sewa = Sewa::findOrFail($id);
        $tanggalSelesaiAsli = new \DateTime($sewa->tanggal_selesai);
        $tanggalSelesaiBaru = new \DateTime($request->tanggal_selesai_baru);
    
        $durasiTambahan = $tanggalSelesaiBaru->diff($tanggalSelesaiAsli)->days;
        $hargaTambahan = $durasiTambahan * $sewa->kendaraan->harga;
        $totalHargaBaru = $sewa->total_harga + $hargaTambahan; 
        $buktiPembayaran = $request->file('bukti_pembayaran_tambahan')->store('bukti_pembayaran');
    
        $sewa->update([
            'tanggal_selesai' => $request->tanggal_selesai_baru,
            'total_harga' => $totalHargaBaru, 
            'harga_setelah_diskon' => $totalHargaBaru, 
            'harga_tambahan' => $hargaTambahan,
            'bukti_pembayaran_tambahan' => $buktiPembayaran,
            'status' => 'perpanjangan sewa', 
        ]);
    
        return redirect()->route('sewa.riwayat')->with('success', 'Perpanjangan sewa berhasil.');
    }
    


    public function riwayat()
    {
        $sewa = Sewa::where('wisatawan_id', Auth::user()->wisatawan->id)->get();
        return view('riwayat', compact('sewa'));
    }

    public function uploadBuktiPembayaran(Request $request, Sewa $sewa)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $filePath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            $sewa->update([
                'bukti_pembayaran' => $filePath,
                'status' => 'menunggu_konfirmasi',
            ]);
        }

        return redirect()->route('sewa.riwayat')->with('success', 'Bukti pembayaran berhasil diunggah. Mohon tunggu konfirmasi.');
    }
    public function updateStatus(Request $request, $id)
    {
        $sewa = Sewa::findOrFail($id);

        if ($request->status == 'setuju') {
            $sewa->status = 'sedang_diproses';
        } elseif ($request->status == 'tolak') {
            $sewa->status = 'dibatalkan';
        } elseif ($request->status == 'diterima') {
            $sewa->status = 'diterima';
        } elseif ($request->status == 'selesai') {
            $sewa->status = 'selesai';
        } else {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $sewa->save();

        return redirect()->back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }


    private function generateKodeSewa()
    {
        return 'SEWA-' . strtoupper(uniqid());
    }
}
