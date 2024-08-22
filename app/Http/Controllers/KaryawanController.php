<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15|unique:karyawan',
        ]);

        Karyawan::create($request->all());
        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15|unique:karyawan,no_telepon,' . $karyawan->id,
        ]);

        $karyawan->update($request->all());
        return redirect()->back()->with('success', 'Karyawan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->back()->with('success', 'Karyawan berhasil dihapus');
    }
}
