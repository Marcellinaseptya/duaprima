<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <- Tambahkan ini
use App\Models\Sopir;

class LaporanKerusakan extends Model
{

    protected $table='laporan_kerusakan';
    
    protected $fillable = [
        'sopir_id', 
        'mastertruk_id', 
        'tanggal', 
        'deskripsi_kerusakan',
        'foto', 
        'status', 
        
    ];

    public function mastertruk() {
        return $this->belongsTo(MasterTruk::class, 'mastertruk_id');
    }

    public function sopir() {
        return $this->belongsTo(Sopir::class, 'sopir_id');
    }

    public function maintenance() {
        return $this->hasOne(Maintenance::class);
    }
}
