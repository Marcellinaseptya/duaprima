<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTruk extends Model
{
    use HasFactory;

    protected $table = 'master_truk'; // tabel kamu singular
    protected $fillable = [
        'plat_nomor',
        'jenis_truk',
        'status',
        'tahun',
        'merk',
        'warna',
        'kapasitas',
        'keterangan'
    ];

    // Relasi ke Sopir (1 truk dipakai 1 sopir)
    public function sopir()
    {
        return $this->hasOne(Sopir::class, 'mastertruk_id');
    }

    // Relasi ke jadwal operasional
    public function jadwal()
    {
        return $this->hasMany(JadwalOperasional::class, 'mastertruk_id');
    }

    // Relasi ke Trip Berangkat
    public function tripBerangkat()
    {
        return $this->hasMany(TripBerangkat::class, 'mastertruk_id');
    }

    // Relasi ke Maintenance
    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'mastertruk_id');
    }

    // Ambil trip terakhir
    public function tripTerakhir()
    {
        return $this->hasOne(TripBerangkat::class, 'mastertruk_id')->latestOfMany();
    }

    // accessor supaya bisa dipanggil pakai camelCase
    public function getPlatNomorAttribute()
    {
        return $this->attributes['plat_nomor'];
    }

}