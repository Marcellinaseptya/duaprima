<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    // Nama tabel (jika tidak sesuai konvensi Laravel)
    protected $table = 'pemasukans';

    // Kolom yang boleh diisi
    protected $fillable = [
        'tanggal',
        'sumber',
        'nominal',
        'keterangan',
    ];
}
