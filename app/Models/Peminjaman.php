<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'sumber',
        'nominal',
        'keterangan',
    ];
    public function sopir()
{
    return $this->belongsTo(Sopir::class);
}
}
