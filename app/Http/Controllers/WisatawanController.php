<?php
namespace App\Http\Controllers;

use App\Models\Wisatawan;
use Illuminate\Http\Request;

class WisatawanController extends Controller
{
    public function index()
    {
        $wisatawans = Wisatawan::with('user')->get();
        return view('admin.wisatawan.index', compact('wisatawans'));
    }

    public function create()
    {
        return view('wisatawan.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'no_telepon' => 'required',
    //         'alamat' => 'required',
    //         'ktp' => 'required',
    //         'npwp' => 'required',
    //         'sim' => 'required',
    //     ]);

    //     $user = auth()->user();
    //     $wisatawan = $user->wisatawan()->create($request->all());

    //     return redirect()->route('wisatawan.index')->with('success', 'Data Wisatawan Berhasil Ditambahkan');
    // }

    public function edit(Wisatawan $wisatawan)
    {
        return view('wisatawan.edit', compact('wisatawan'));
    }

    public function update(Request $request, Wisatawan $wisatawan)
    {
        $request->validate([
            'nama' => 'required',
            'no_telepon' => 'required',
            'alamat' => 'required',
            'ktp' => 'required',
            'npwp' => 'required',
            'sim' => 'required',
        ]);

        $wisatawan->update($request->all());

        return redirect()->route('wisatawan.index')->with('success', 'Data Wisatawan Berhasil Diperbarui');
    }

    public function destroy(Wisatawan $wisatawan)
    {
        $wisatawan->delete();

        return redirect()->route('wisatawan.index')->with('success', 'Data Wisatawan Berhasil Dihapus');
    }
}
