<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Panggil class seeder lain yang ada di sistem
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            MasterMerkSeeder::class,
            SparepartSeeder::class,
        ]);
    }
}