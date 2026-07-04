<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // Sesuaikan nama tabel dengan yang ada di database
    protected $fillable = ['nama_kategori'];

    // Relasi dengan modul
    public function moduls()
    {
        return $this->hasMany(Modul::class);
    }
}
