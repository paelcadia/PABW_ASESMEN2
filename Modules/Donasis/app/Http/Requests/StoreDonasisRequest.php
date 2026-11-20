<?php

namespace Modules\Donasis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonasisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'kode_donasi' => ['required', 'string', 'max:255', 'unique:donasis,kode_donasi'],
            'nama_pangan' => ['required', 'string', 'max:255'],
            'lokasi_ambil' => ['required', 'string', 'max:255'],
            'batas_porsi' => ['required', 'integer', 'min:1'],
            'tanggal_bagi' => ['required', 'date'],
        ];
    }
}
