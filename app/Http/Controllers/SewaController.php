<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Promo;
use App\Models\Sewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function index()
    {
        $sewas = Sewa::with('wisatawan', 'kendaraan', 'jenisPembayaran')->orderBy('created_at', 'desc')->get();
        $karyawans = Karyawan::all();
        return view('admin.sewa.index', compact('sewas', 'karyawans'));
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

        // Check for existing bookings
        $existingBookings = Sewa::where('kendaraan_id', $request->kendaraan_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($existingBookings) {
            return redirect()->back()->withErrors(['kendaraan_id' => 'Kendaraan ini sudah disewa pada periode yang dipilih.'])->withInput();
        }

        // Calculate the duration in hours
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

        // Redirect the user to the rental history with a success message
        return redirect()->route('sewa.riwayat')->with('success', 'Pemesanan berhasil dibuat.');
    }


    public function perpanjang(Request $request, $id)
    {
        $request->validate([
            'tanggal_selesai_baru' => 'required|date|after_or_equal:tanggal_selesai',
            'bukti_pembayaran_tambahan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $sewa = Sewa::findOrFail($id);
        $tanggalSelesaiAsli = \Carbon\Carbon::parse($sewa->tanggal_selesai)->startOfDay();
        $tanggalSelesaiBaru = \Carbon\Carbon::parse($request->tanggal_selesai_baru)->startOfDay();
        


        $durasiTambahan = $tanggalSelesaiAsli->diffInDays($tanggalSelesaiBaru);
        $hargaTambahan = $durasiTambahan * $sewa->kendaraan->harga;
        $totalHargaBaru = $sewa->total_harga + $hargaTambahan;
        $buktiPembayaran = $request->file('bukti_pembayaran_tambahan')->store('bukti_pembayaran');

        $sewa->update([
            'tanggal_selesai' => $request->tanggal_selesai_baru,
            'tanggal_selesai_baru' => $request->tanggal_selesai_baru,
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
        $sewa = Sewa::where('wisatawan_id', Auth::user()->wisatawan->id)->orderBy('created_at', 'desc')->get();
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
        }elseif ($request->status == 'perpanjangan') {
            $sewa->status = 'perpanjangan sewa';
        } else {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $sewa->save();

        return redirect()->back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    public function assignKaryawan(Request $request, $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
        ]);

        $sewa = Sewa::findOrFail($id);
        $sewa->karyawan_id = $request->input('karyawan_id');
        $sewa->status = 'sedang_diproses';
        $sewa->save();

        return redirect()->back()->with('success', 'Karyawan berhasil ditugaskan');
    }


    private function generateKodeSewa()
    {
        return 'SEWA-' . strtoupper(uniqid());
    }
}
