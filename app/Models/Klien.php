<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'klien';

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'no_hp',
        'email',
        'status',
        'keterangan',
    ];

    public function riwayatStatus()
    {
        return $this->hasMany(KlienRiwayatStatus::class)->orderBy('mulai', 'desc');
    }

    public function statusTerakhir()
    {
        return $this->riwayatStatus()->first();
    }
}
