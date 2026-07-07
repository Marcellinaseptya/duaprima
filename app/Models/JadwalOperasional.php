<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalOperasional extends Model
{
    use HasFactory;

    protected $table = 'jadwal_operasional';

    protected $fillable = [
        'tanggal',
        'sopir_id',
        'mastertruk_id',
        'plat_nomor',
        'klien_id',
        'tujuan',
        'rute',
        'lokasi_berangkat',
        'bruto',
        'tara',
        'netto',
        'no_surat_jalan',
        'catatan',
        'status',
        'alasan_batal',
        'uang_jalan',
        'rit_ke'
    ];

    // Relasi ke Sopir
    public function sopir()
    {
        return $this->belongsTo(Sopir::class, 'sopir_id'); 
    }

    // Relasi ke MasterTruk
    public function truk()
    {
        return $this->belongsTo(MasterTruk::class, 'mastertruk_id');
    }

    public function masterTruk()
    {
        return $this->belongsTo(MasterTruk::class, 'mastertruk_id');
    }

    // Relasi ke Klien
    public function klien()
    {
        return $this->belongsTo(Klien::class, 'klien_id'); 
    }

    // Relasi Trip
    public function tripBerangkat() 
    {
        return $this->hasOne(TripBerangkat::class, 'jadwal_id');
    }
    
    public function tripPulang() 
    {
        return $this->hasOne(TripPulang::class, 'jadwal_id');
    }

    // Relasi ke Nota Hauling
    public function notaHauling()
    {
        return $this->hasOne(\App\Models\LaporanNotaHauling::class, 'jadwal_id');
    }

    // Scope: Ambil jadwal aktif untuk sopir
    public static function jadwalAktifSopir($sopirId)
    {
        return self::where('sopir_id', $sopirId)
            ->whereIn('status', ['Siap Berangkat', 'Berangkat'])
            ->orderBy('tanggal', 'asc')
            ->first();
    }

    // Scope: Histori semua jadwal oleh sopir
    public static function historiSopir($sopirId)
    {
        return self::where('sopir_id', $sopirId)
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    
}