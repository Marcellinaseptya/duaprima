<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanNotaHauling extends Model
{
    use HasFactory;

    protected $table = 'laporan_nota_hauling';

    protected $fillable = [
        'sopir_id',
        'tanggal',
        'file_nota',
        'bukti_transfer',
        'tarif_per_rit',
        'jumlah_ritase',
        'status',
        'keterangan',
    ];

    // Relasi ke Sopir
    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }

    public function jadwal()
{
    return $this->belongsTo(\App\Models\JadwalOperasional::class, 'jadwal_id');
}
}
