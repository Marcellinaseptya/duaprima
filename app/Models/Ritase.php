<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← Tambahkan ini!

class Ritase extends Model
{
    use HasFactory;
    protected $table='ritase';
    protected $fillable = [
        'tanggal', 'sopir_id', 'trip_berangkat_id', 'muatan_netto', 'tarif', 'biaya_bbm', 'gaji_sopir', 'keuntungan_cv', 'bonus', 'harga_terbaru'
    ];

    public function tripBerangkat()
    {
        return $this->belongsTo(\App\Models\JadwalOperasional::class, 'trip_berangkat_id');
    }


    public function sopir()
{
    return $this->belongsTo(\App\Models\Sopir::class);
}

public function truk()
{
    return $this->belongsTo(\App\Models\Truk::class);
}


public function jadwal()
{
    return $this->belongsTo(JadwalOperasional::class, 'jadwal_operasional_id');
}


public function hitungKeuangan()
{
    $this->harga_bersih = $this->netto * $this->tarif;
    $this->gaji_sopir = $this->harga_bersih * 0.25; // 25%
    $this->untung_cv = $this->harga_bersih * 0.75;  // 75%
    $this->save();
}

}
