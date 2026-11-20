<?php

namespace Modules\Donasis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDonasisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'kode_donasi' => ['required', 'string', 'max:255', Rule::unique('donasis', 'kode_donasi')->ignore($this->route('Donasi'))],
            'nama_pangan' => ['required', 'string', 'max:255'],
            'lokasi_ambil' => ['required', 'string', 'max:255'],
            'batas_porsi' => ['required', 'integer', 'min:1'],
            'tanggal_bagi' => ['required', 'date'],
        ];
    }
}
