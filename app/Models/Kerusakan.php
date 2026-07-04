<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    protected $table = 'kerusakans';  // sesuaikan dengan nama tabel di database

    public function truk()
    {
        return $this->belongsTo(Truk::class);
    }

    public function sopir()
{
    return $this->belongsTo(Sopir::class, 'sopir_id');
}
}


