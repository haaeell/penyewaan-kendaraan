<?php
namespace App\Http\Controllers;

use App\Models\SettingInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingInformasiController extends Controller
{
    public function index()
    {
        $settings = SettingInformasi::first();
        return view('setting_informasi.index', compact('settings'));
    }

    public function edit()
    {
        $settings = SettingInformasi::first();
        return view('setting_informasi.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'nama_perusahaan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $setting_informasi = SettingInformasi::first();

        if ($request->hasFile('logo')) {
            if ($setting_informasi->logo) {
                Storage::delete($setting_informasi->logo);
            }
            $logoPath = $request->file('logo')->store('perusahaan/logo','public');
        } else {
            $logoPath = $setting_informasi->logo;
        }

        $setting_informasi->update([
            'logo' => $logoPath,
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'email' => $request->input('email'),
            'no_telepon' => $request->input('no_telepon'),
            'alamat' => $request->input('alamat'),
        ]);

        return redirect()->route('settings.index')->with('status', 'Settings updated successfully.');
    }
}
