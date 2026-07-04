<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tahun;

class TahunSeeder extends Seeder
{
    public function run()
    {
        Tahun::create(['tahun' => '2023']);
        Tahun::create(['tahun' => '2024']);
    }
}

