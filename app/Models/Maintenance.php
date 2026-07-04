<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    protected $table='maintenance';
    protected $fillable = [
        'laporan_kerusakan_id', 'mastertruk_id', 'tanggal_perbaikan',
        'deskripsi_perbaikan', 'biaya_servis', 'foto_bukti', 'sparepat_id'
    ];
    public function laporanKerusakan()
    {
        return $this->belongsTo(LaporanKerusakan::class);
    }

  // app/Models/Maintenance.php
public function mastertruk()
{
    return $this->belongsTo(MasterTruk::class, 'mastertruk_id');
}

    

    public function laporan()
    {
        return $this->belongsTo(LaporanKerusakan::class, 'laporan_kerusakan_id');
    }

    public function sparepart()
{
    return $this->belongsTo(Sparepart::class, 'sparepart_id');
}
}