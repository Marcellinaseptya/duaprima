<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals'; // pastikan sama dengan nama tabel di database

    protected $fillable = [
        'nama_sopir',
        'plat_truk',
        'tujuan',
        'status',
    ];
}