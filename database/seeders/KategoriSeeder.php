<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        Kategori::create(['nama_kategori' => 'Modul', 'tahun_id' => 1]);
        Kategori::create(['nama_kategori' => 'Video', 'tahun_id' => 1]);
        Kategori::create(['nama_kategori' => 'Foto', 'tahun_id' => 1]);
    }
}