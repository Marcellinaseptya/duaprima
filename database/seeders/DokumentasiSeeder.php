<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumentasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dokumentasi')->insert([
            [
                'DOKUMENTASI_ID' => 1,  // Menambahkan nilai untuk DOKUMENTASI_ID
                'judul' => 'Modul Pemrograman Dasar',
                'jenis_dokumen' => 'modul',
                'file_path' => 'modul_files/dasar.pdf',
                'kategori_id' => 1, // Sesuaikan dengan kategori yang ada
                'tahun_id' => 1, // Sesuaikan dengan tahun yang ada
                'tanggal_dokumen' => '2024-12-01',
                'deskripsi' => 'Modul untuk belajar pemrograman dasar.',
            ],
            [
                'DOKUMENTASI_ID' => 2,  // Menambahkan nilai untuk DOKUMENTASI_ID
                'judul' => 'Modul Pengembangan Web',
                'jenis_dokumen' => 'modul',
                'file_path' => 'modul_files/web.pdf',
                'kategori_id' => 1, // Sesuaikan dengan kategori yang ada
                'tahun_id' => 1, // Sesuaikan dengan tahun yang ada
                'tanggal_dokumen' => '2024-12-01',
                'deskripsi' => 'Modul untuk belajar pengembangan web.',
            ],
        ]);
    }
}