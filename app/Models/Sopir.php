<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    use HasFactory;

    protected $table = 'sopir';

    protected $fillable = [
        'user_id',
        'mastertruk_id', // ✅ sesuai dengan input form & DB
        'nama',
        'no_hp',
        'alamat',
        'status',
    ];

    public function user()
    { 
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    

    public function mastertruk()
    {
        return $this->belongsTo(MasterTruk::class, 'mastertruk_id');
    
    }

    public function notaHauling()
{
    return $this->hasMany(LaporanNotaHauling::class, 'sopir_id');
}

public function notaPengeluaran()
{
    return $this->hasMany(NotaPengeluaran::class);
}

public function jadwalOperasional()
{
    return $this->hasMany(JadwalOperasional::class, 'sopir_id');
}

}
