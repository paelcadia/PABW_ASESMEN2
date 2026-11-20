<?php

namespace Modules\Donasis\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Pengajuan\Models\Pengajuan;

class Donasis extends Model
{
    use HasFactory;

    protected $table = 'donasis';

    protected $fillable = [
        'kode_donasi',
        'nama_pangan',
        'lokasi_ambil',
        'batas_porsi',
        'tanggal_bagi',
    ];

    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class);
    }
}
