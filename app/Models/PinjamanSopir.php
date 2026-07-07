<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PinjamanSopir extends Model
{
    use HasFactory;

    protected $fillable = [
        'sopir_id', 'tanggal', 'jumlah', 'keterangan', 'status_pelunasan'
    ];

    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }
}