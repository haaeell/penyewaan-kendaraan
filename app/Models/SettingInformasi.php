<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingInformasi extends Model
{
    use HasFactory;

    protected $table = 'setting_informasi'; 

    protected $fillable = [
        'logo',
        'nama_perusahaan',
        'email',
        'no_telepon',
        'alamat',
    ];
}
