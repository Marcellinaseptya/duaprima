<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table='transaksi';
    protected $fillable = [
        'tanggal',
        'jenis',         // 'pemasukan' atau 'pengeluaran'
        'kategori',      // contoh: 'ritase', 'pembelian sparepart', 'pinjaman', dll
        'nominal',       // jumlah uang
        'keterangan',
        'sumber',        // asal transaksi (bisa relasi nama modul)
        'status_lunas',  // hanya untuk kategori 'pinjaman'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}