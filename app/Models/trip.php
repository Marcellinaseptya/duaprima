<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips'; // pastikan tabel kamu bernama 'trips'
    
    protected $fillable = [
        'jadwal_id',       // relasi ke jadwal_operasional
        'ritase',
        'muatan_netto',
        'tarif_per_rit',
        'bonus',
        'truk_ID',
        'biaya_bbm',
        'total_gaji_sopir',
        'total_cv',
        'catatan',
        'nota_bbm',
        'waktu_selesai'
    ];


    // Trip.php
    public function mastertruk()
    {
        return $this->belongsTo(MasterTruk::class, 'truk_id'); // sesuaikan foreign key
    }
    

public function maintenance()
{
    return $this->hasMany(Maintenance::class, 'trip_id');
}

public function spareparts()
{
    return $this->hasMany(Sparepart::class, 'trip_id');
}

public function jadwal()
{
    return $this->belongsTo(Jadwal::class, 'jadwal_id');
}


}
