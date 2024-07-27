<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wisatawan;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_telepon' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string', 'max:255'],
            'ktp' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'npwp' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'sim' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);
    }

    protected function create(array $data)
    {
        $ktpPath = request()->file('ktp')->store('documents/ktp', 'public');
        $npwpPath = request()->file('npwp')->store('documents/npwp', 'public');
        $simPath = request()->file('sim')->store('documents/sim', 'public');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'wisatawan', 
        ]);

        Wisatawan::create([
            'user_id' => $user->id,
            'nama' => $data['name'],
            'no_telepon' => $data['no_telepon'],
            'alamat' => $data['alamat'],
            'ktp' => $ktpPath,
            'npwp' => $npwpPath,
            'sim' => $simPath,
        ]);

        return $user;
    }
}

