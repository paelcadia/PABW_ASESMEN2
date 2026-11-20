<?php

namespace Modules\Pengajuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Donasis\Models\Donasis;

class UpdatePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'pemohon';
    }

    public function rules(): array
    {
        return [
            'donasi_id' => ['required', 'integer', 'exists:donasis,id'],
            'jumlah_porsi' => ['required', 'integer', 'min:1'],
            'tanggal_ambil' => ['required', 'date'],
            'keperluan' => ['required', 'string'],
            'foto_bukti' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $donasi = Donasis::find($this->input('donasi_id'));
            if (!$donasi) return;
            if ((int) $this->input('jumlah_porsi') > $donasi->batas_porsi) {
                $validator->errors()->add('jumlah_porsi', 'Jumlah porsi tidak boleh melebihi batas porsi donasi (' . $donasi->batas_porsi . ').');
            }
            if ($this->filled('tanggal_ambil') && $this->input('tanggal_ambil') !== $donasi->tanggal_bagi) {
                $validator->errors()->add('tanggal_ambil', 'Tanggal ambil harus sama dengan tanggal bagi (' . $donasi->tanggal_bagi . ').');
            }
        });
    }
}
