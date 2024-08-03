<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::all();
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo.create');
    }

    public function checkPromo($kode)
{
    $promo = Promo::where('kode', $kode)
        ->where('status', true) // Pastikan promo aktif
        ->whereDate('tanggal_mulai', '<=', now())
        ->whereDate('tanggal_selesai', '>=', now())
        ->first();
    
    if ($promo) {
        return response()->json([
            'valid' => true,
            'jenis' => $promo->jenis,
            'nilai' => $promo->nilai
        ]);
    } else {
        return response()->json([
            'valid' => false
        ]);
    }
}


    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:promo',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:diskon_persen,potongan_harga',
            'nilai' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date'
        ]);

        $promo = new Promo($request->all());

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('promos', 'public');
            $promo->gambar = $gambarPath;
        }

        $promo->save();

        return redirect()->route('promos.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promo.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'kode' => 'required|string|unique:promo,kode,' . $promo->id,
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:diskon_persen,potongan_harga',
            'nilai' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date'
        ]);

        $promo->fill($request->all());

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($promo->gambar) {
                Storage::disk('public')->delete($promo->gambar);
            }

            $gambarPath = $request->file('gambar')->store('promos', 'public');
            $promo->gambar = $gambarPath;
        }

        $promo->save();

        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        // Hapus gambar jika ada
        if ($promo->gambar) {
            Storage::disk('public')->delete($promo->gambar);
        }

        $promo->delete();

        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus.');
    }
}
