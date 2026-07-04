<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaBbm extends Model
{
    use HasFactory;

    protected $table = 'nota_bbm';

    protected $fillable = [
        'sopir_id',
        'file',
        'tanggal',
        'keterangan',
        'status',
        'jumlah'
    ];

    public function sopir()
    {
        return $this->belongsTo(User::class, 'sopir_id');
    }
}
