<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TripBerangkat extends Model
{
    use HasFactory;

    protected $table = 'trip_berangkat'; 

    protected $fillable = [
        'jadwal_id',
        'sopir_id', 
        'uang_jalan', 
        'uang_makan', 
        'tanggal_berangkat', 
        'lokasi_berangkat', 
        'waktu_mulai',
        'nota_perjalanan',
        'catatan'
    ];

    // Relasi ke Sopir
    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }

    // Relasi ke MasterTruk
    public function truk()
    {
        return $this->belongsTo(MasterTruk::class, 'master_truk_id');
    }

    // Relasi ke Klien
    public function klien()
    {
        return $this->belongsTo(Klien::class);
    }

    // Relasi ke Ritase
    public function ritase()
    {
        return $this->hasOne(Ritase::class);
        // return $this->hasMany(Ritase::class); ← kalau 1 trip bisa lebih dari 1 ritase
    }

    // Relasi ke TripPulang
    public function tripPulang()
    {
        return $this->hasOne(TripPulang::class, 'trip_berangkat_id'); 
        // pastikan foreign key-nya benar di tabel trip_pulang
    }
}
