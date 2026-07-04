<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianSparepart extends Model
{
    use HasFactory;

    protected $table = 'pembelian_sparepart';

    protected $fillable = [
        'sparepart_id',
        'nama_sparepart',
        'jumlah',
        'harga_total',
        'supplier',
        'harga_satuan',
        'tanggal_pembelian',
        'catatan',
        'nota',
    ];

    public function sparepart()
{
    return $this->belongsTo(Sparepart::class);
}
   
}