<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wisatawan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create wisatawan user
        $wisatawan = User::create([
            'name' => 'Wisatawan',
            'email' => 'wisatawan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'wisatawan',
        ]);

        // Create related wisatawan data
        Wisatawan::create([
            'user_id' => $wisatawan->id,
            'nama' => 'John Doe',
            'no_telepon' => '08123456789',
            'alamat' => 'Jl. Contoh No.1, Jakarta',
            'ktp' => '1234567890',
            'npwp' => '123456789012345',
            'sim' => 'A123456789',
        ]);
    }
}
