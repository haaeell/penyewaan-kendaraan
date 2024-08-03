<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingInformasiSeeder extends Seeder
{
    public function run()
    {
        Storage::makeDirectory('logos');
        $logoPath = 'logos/logo-dummy.png'; 
        DB::table('setting_informasi')->insert([
            'logo' => $logoPath,
            'nama_perusahaan' => 'Contoh Perusahaan',
            'email' => 'info@contohperusahaan.com',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Contoh Alamat No. 123, Kota Contoh, Negara Contoh',
        ]);
    }
}

