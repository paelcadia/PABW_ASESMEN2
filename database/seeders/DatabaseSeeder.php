<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            \Modules\Donasis\Database\Seeders\DonasisDatabaseSeeder::class,
            \Modules\Pengajuan\Database\Seeders\PengajuanDatabaseSeeder::class,
        ]);
    }
}
