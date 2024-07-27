<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $jenisPembayaran = JenisPembayaran::all();
        return view('admin.jenis_pembayaran.index', compact('jenisPembayaran'));
    }

    public function create()
    {
        return view('admin.jenis_pembayaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_rek' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarPath = $request->file('gambar') ? $request->file('gambar')->store('images/jenis_pembayaran', 'public') : null;

        JenisPembayaran::create([
            'nama' => $request->nama,
            'no_rek' => $request->no_rek,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('jenis_pembayaran.index')->with('success', 'Jenis pembayaran ditambahkan');
    }

    public function edit(JenisPembayaran $jenisPembayaran)
    {
        return view('admin.jenis_pembayaran.edit', compact('jenisPembayaran'));
    }

    public function update(Request $request, JenisPembayaran $jenisPembayaran)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_rek' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarPath = $request->file('gambar') ? $request->file('gambar')->store('images/jenis_pembayaran', 'public') : $jenisPembayaran->gambar;

        $jenisPembayaran->update([
            'nama' => $request->nama,
            'no_rek' => $request->no_rek,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('jenis_pembayaran.index')->with('success', 'Jenis pembayaran diperbarui');
    }

    public function destroy(JenisPembayaran $jenisPembayaran)
    {
        if ($jenisPembayaran->gambar) {
            Storage::disk('public')->delete($jenisPembayaran->gambar);
        }
        $jenisPembayaran->delete();
        return redirect()->route('jenis_pembayaran.index')->with('success', 'Jenis pembayaran dihapus');
    }
}