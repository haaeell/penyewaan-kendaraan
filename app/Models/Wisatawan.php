<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisatawan extends Model
{
    use HasFactory;

    protected $table = 'wisatawan';

    protected $fillable = [
        'user_id',
        'nama',
        'no_telepon',
        'alamat',
        'ktp',
        'npwp',
        'sim',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
