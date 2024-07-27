<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        return view('admin.kendaraan.index', compact('kendaraans'));
    }


    public function create()
    {
        return view('admin.kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis' => 'required|in:mobil,motor',
            'type' => 'required|string|max:255',
            'plat_nomor' => 'required|unique:kendaraan',
            'keterangan' => 'nullable|string',
            'tahun' => 'required|integer',
            'seating_capacity' => 'nullable|integer',
            'merk' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        $kendaraan = new Kendaraan();
        $kendaraan->nama = $request->input('nama');
        $kendaraan->jenis = $request->input('jenis');
        $kendaraan->type = $request->input('type');
        $kendaraan->plat_nomor = $request->input('plat_nomor');
        $kendaraan->keterangan = $request->input('keterangan');
        $kendaraan->tahun = $request->input('tahun');
        $kendaraan->seating_capacity = $request->input('seating_capacity');
        $kendaraan->merk = $request->input('merk');
        $kendaraan->harga = $request->input('harga');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('kendaraan', 'public');
            $kendaraan->foto = $path;
        }

        $kendaraan->save();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis' => 'required|in:mobil,motor',
            'type' => 'required|string|max:255',
            'plat_nomor' => 'required|unique:kendaraan,plat_nomor,' . $kendaraan->id,
            'keterangan' => 'nullable|string',
            'tahun' => 'required|integer',
            'seating_capacity' => 'nullable|integer',
            'merk' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        $kendaraan->nama = $request->input('nama');
        $kendaraan->jenis = $request->input('jenis');
        $kendaraan->type = $request->input('type');
        $kendaraan->plat_nomor = $request->input('plat_nomor');
        $kendaraan->keterangan = $request->input('keterangan');
        $kendaraan->tahun = $request->input('tahun');
        $kendaraan->seating_capacity = $request->input('seating_capacity');
        $kendaraan->merk = $request->input('merk');
        $kendaraan->harga = $request->input('harga');

        if ($request->hasFile('foto')) {
            if ($kendaraan->foto) {
                Storage::delete('public/' . $kendaraan->foto);
            }
            $file = $request->file('foto');
            $path = $file->store('kendaraan', 'public');
            $kendaraan->foto = $path;
        }

        $kendaraan->save();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }



    public function destroy(Kendaraan $kendaraan)
    {
        if ($kendaraan->foto) {
            Storage::delete($kendaraan->foto);
        }
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
