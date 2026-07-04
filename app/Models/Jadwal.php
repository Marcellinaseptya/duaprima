<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';

    protected $fillable = [
        'sopir_id',  // ← ini penting
        'plat_truk',
        'tujuan',
        'status',
        'tanggal',
    ];

    public function sopir()
    {
        return $this->belongsTo(Sopir::class, 'sopir_id');
    }

    public function masterTruk()
{
    // ambil truk dari jadwal yang terkait
    return $this->hasOneThrough(
        \App\Models\MasterTruk::class, // model tujuan
        \App\Models\JadwalOperasional::class, // model perantara
        'id',      // foreign key di JadwalOperasional (jadwal_id di TripPulang)
        'id',      // foreign key di MasterTruk
        'jadwal_id', // local key di TripPulang
        'truk_id'    // local key di JadwalOperasional
    );
}

}