<?php

namespace App\Http\Controllers;

use App\Models\Wisatawan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wisatawan = Wisatawan::where("user_id", $user->id)->first();
        return view('profile.index', compact('user', 'wisatawan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'sim' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();
        $user->update($request->only('name', 'email'));

        $wisatawan = Wisatawan::where('user_id', $user->id)->first();
        if (!$wisatawan) {
            $wisatawan = new Wisatawan();
            $wisatawan->user_id = $user->id;
        }
        $wisatawan->nama = $request->input('name');
        $wisatawan->no_telepon = $request->input('no_telepon');
        $wisatawan->alamat = $request->input('alamat');

        if ($request->hasFile('ktp')) {
            $ktpPath = $request->file('ktp')->store('documents/ktp', 'public');
            $wisatawan->ktp = $ktpPath;
        }
        if ($request->hasFile('npwp')) {
            $npwpPath = $request->file('npwp')->store('documents/npwp', 'public');
            $wisatawan->npwp = $npwpPath;
        }
        if ($request->hasFile('sim')) {
            $simPath = $request->file('sim')->store('documents/sim', 'public');
            $wisatawan->sim = $simPath;
        }

        $wisatawan->save();

        return redirect()->route('wisatawan.profile.index')->with('status', 'Profile updated successfully!');
    }

    public function editPassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verifikasi password saat ini
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Password updated successfully!');
    }
}
