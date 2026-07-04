<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sparepart;

class SparepartSeeder extends Seeder
{
    public function run()
    {
        $spareparts = [
            ['nama_sparepart' => 'Ban', 'stok' => 10, 'harga_satuan' => 1500000, 'satuan' => 'pcs', 'supplier' => 'Bengkel Makmur Jaya'],
            ['nama_sparepart' => 'Oli Mesin', 'stok' => 20, 'harga_satuan' => 75000, 'satuan' => 'liter', 'supplier' => 'Toko Oli Sejahtera'],
            ['nama_sparepart' => 'Filter Udara', 'stok' => 15, 'harga_satuan' => 50000, 'satuan' => 'pcs', 'supplier' => 'Sparepart Motorindo'],
            ['nama_sparepart' => 'Kampas Rem', 'stok' => 12, 'harga_satuan' => 250000, 'satuan' => 'pcs', 'supplier' => 'CV Rem Prima'],
            ['nama_sparepart' => 'Aki', 'stok' => 8, 'harga_satuan' => 1200000, 'satuan' => 'unit', 'supplier' => 'Bengkel Listrik Mobil Anugrah'],
            ['nama_sparepart' => 'Filter Solar', 'stok' => 10, 'harga_satuan' => 60000, 'satuan' => 'pcs', 'supplier' => 'UD Sumber Jaya'],
            ['nama_sparepart' => 'Busi', 'stok' => 30, 'harga_satuan' => 40000, 'satuan' => 'pcs', 'supplier' => 'Toko Sinar Otomotif'],
            ['nama_sparepart' => 'Lampu Depan', 'stok' => 10, 'harga_satuan' => 200000, 'satuan' => 'pcs', 'supplier' => 'Bengkel Cahaya Mobil'],
            ['nama_sparepart' => 'Fan Belt', 'stok' => 10, 'harga_satuan' => 80000, 'satuan' => 'pcs', 'supplier' => 'CV Teknik Abadi'],
            ['nama_sparepart' => 'Kabel Rem', 'stok' => 7, 'harga_satuan' => 150000, 'satuan' => 'pcs', 'supplier' => 'Toko Sparepart Truk 88'],
        ];

        foreach ($spareparts as $sparepart) {
            Sparepart::create($sparepart);
        }
    }
}