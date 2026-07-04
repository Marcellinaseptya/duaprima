<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotaHauling extends Model
{
    use HasFactory;

    protected $table = 'nota_hauling';

    protected $fillable = [
        'sopir_id',
        'tanggal',
        'jumlah_rit',
        'tarif_per_rit',
        'bonus',
        'total_pemasukan',
        'file_nota',
        'keterangan',
    ];

    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }
}
