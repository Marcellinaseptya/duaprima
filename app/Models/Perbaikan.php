<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sopir_id', 'mastertruk_id', 'keluhan', 'status', 'foto', 'tanggal_perbaikan'
    ];

    public function sopir()
    {
        return $this->belongsTo(User::class, 'sopir_id');
    }

    public function truk()
    {
        return $this->belongsTo(mastertruk::class, 'mastertruk_id');
    }
}

