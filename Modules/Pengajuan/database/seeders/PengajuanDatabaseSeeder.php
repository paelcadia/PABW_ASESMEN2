<?php

namespace Modules\Pengajuan\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\Donasis\Models\Donasis;
use Modules\Pengajuan\Models\Pengajuan;

class PengajuanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $d001 = Donasis::where('kode_donasi', 'D001')->firstOrFail();
        $p1 = User::where('email', 'pemohon1@foodshare.local')->firstOrFail();
        $p2 = User::where('email', 'pemohon2@foodshare.local')->firstOrFail();

        Pengajuan::updateOrCreate(['user_id' => $p1->id, 'donasi_id' => $d001->id, 'jumlah_porsi' => 3], [
            'tanggal_ambil' => '2026-11-20',
            'keperluan' => 'Membantu keluarga penerima bantuan mahasiswa fiktif.',
            'status' => 'Menunggu',
        ]);
        Pengajuan::updateOrCreate(['user_id' => $p1->id, 'donasi_id' => $d001->id, 'jumlah_porsi' => 2], [
            'tanggal_ambil' => '2026-11-20',
            'keperluan' => 'Bantuan pangan untuk warga kampus fiktif.',
            'status' => 'Disetujui',
        ]);
        Pengajuan::updateOrCreate(['user_id' => $p2->id, 'donasi_id' => $d001->id, 'jumlah_porsi' => 1], [
            'tanggal_ambil' => '2026-11-20',
            'keperluan' => 'Pengajuan bantuan untuk simulasi penerima fiktif.',
            'status' => 'Ditolak',
        ]);
    }
}
