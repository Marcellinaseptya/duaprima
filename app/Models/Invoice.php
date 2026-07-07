<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    protected $fillable = [
        'klien_id',
        'kode_invoice',
        'tanggal_invoice',
        'total_tagihan',
        'status',
        'keterangan'
    ];

    public function klien()
    {
        return $this->belongsTo(Klien::class, 'klien_id');
    }
}
