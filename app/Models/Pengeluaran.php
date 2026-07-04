<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    // Nama tabel (jika tidak sesuai konvensi Laravel)
    protected $table = 'pengeluarans';

    // Kolom yang boleh diisi
    protected $fillable = [
        'tanggal',
        'sumber',
        'nominal',
        'keterangan',
    ];
}
