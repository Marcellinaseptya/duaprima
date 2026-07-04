<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterMerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('master_merk')->insert([
            ['nama' => 'Hino'],
            ['nama' => 'Fuso'],
            ['nama' => 'Isuzu'],
            ['nama' => 'Mitsubishi'],
        ]);
    }
}
