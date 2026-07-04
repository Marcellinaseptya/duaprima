<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaPerbaikan extends Model
{
    use HasFactory;

    protected $table = 'nota_perbaikan';
    protected $fillable = [
        'sopir_id',
        'file_nota',
        'tanggal',
        'keterangan',
        'status',
    ];
}