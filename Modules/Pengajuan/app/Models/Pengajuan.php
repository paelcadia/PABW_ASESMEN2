<?php

namespace Modules\Pengajuan\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Donasis\Models\Donasis;

class Pengajuan extends Model
{
    protected $table = 'pengajuans';

    protected $fillable = [
        'user_id',
        'donasi_id',
        'jumlah_porsi',
        'tanggal_ambil',
        'keperluan',
        'status',
        'foto_bukti',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Donasis(): BelongsTo
    {
        return $this->belongsTo(Donasis::class);
    }

    public function donasi(): BelongsTo
    {
        return $this->belongsTo(Donasis::class, 'donasi_id');
    }
}
