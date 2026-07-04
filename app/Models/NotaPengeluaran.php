<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaPengeluaran extends Model
{
    protected $table = 'nota_pengeluaran';

    protected $fillable = [
        'sopir_id',
        'jadwal_id',      // optional
        'jenis',          // enum('hauling', 'bbm', 'perbaikan')
        'file_nota',
        'tanggal',
        'keterangan',     // optional
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }
}