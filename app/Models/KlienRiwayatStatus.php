<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlienRiwayatStatus extends Model
{
    use HasFactory;

    protected $table = 'klien_riwayat_status';

    protected $fillable = [
        'klien_id',
        'status',
        'mulai',
        'selesai',
    ];

    public function klien()
    {
        return $this->belongsTo(Klien::class);
    }
}
