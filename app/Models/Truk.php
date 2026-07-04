<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Truk extends Model
{
    protected $table = 'truks';

    protected $fillable = [
        'mastertruk_id',
        'tanggal',
        'sopir_id',
        'perusahaan',
        'tarif',
        'bbm',
        'netto',
        'keuntungan_sopir',
        'keuntungan_perusahaan',
        'keterangan'
    ];

    /**
     * Relasi: Truk milik satu mastertruk
     * mastertruk_id adalah foreign key ke tabel mastertruks
     */
    public function mastertruk()
    {
        return $this->belongsTo(mastertruk::class);
    }
    
    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }
}