<?php

namespace Modules\Donasis\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Donasis\Models\Donasis;

class DonasisDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['kode_donasi' => 'D001', 'nama_pangan' => 'Paket Nasi Ayam', 'lokasi_ambil' => 'Gerbang Utama Kampus', 'batas_porsi' => 4, 'tanggal_bagi' => '2026-11-20'],
            ['kode_donasi' => 'D002', 'nama_pangan' => 'Paket Sayur Tempe', 'lokasi_ambil' => 'Aula Perpustakaan', 'batas_porsi' => 3, 'tanggal_bagi' => '2026-11-21'],
            ['kode_donasi' => 'D003', 'nama_pangan' => 'Paket Bubur Ayam', 'lokasi_ambil' => 'Pos Satpam Utara', 'batas_porsi' => 5, 'tanggal_bagi' => '2026-11-22'],
            ['kode_donasi' => 'D004', 'nama_pangan' => 'Paket Roti Susu', 'lokasi_ambil' => 'Gedung Kemahasiswaan', 'batas_porsi' => 6, 'tanggal_bagi' => '2026-11-23'],
            ['kode_donasi' => 'D005', 'nama_pangan' => 'Paket Buah Sereal', 'lokasi_ambil' => 'Lobby Rektorat', 'batas_porsi' => 2, 'tanggal_bagi' => '2026-11-24'],
        ];
        foreach ($items as $item) {
            Donasis::updateOrCreate(['nama_pangan' => $item['nama_pangan']], $item);
        }
    }
}
