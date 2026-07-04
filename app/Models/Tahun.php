<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $table = 'tahuns'; // Nama tabel tahun
    protected $primaryKey = 'tahun_id'; // Primary key untuk tahun

    protected $fillable = ['tahun'];

    public function moduls()
    {
        return $this->hasMany(Modul::class, 'tahun_id');
    }
}
