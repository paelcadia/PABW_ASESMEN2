<?php

namespace Modules\Pengajuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DecisionPengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:Disetujui,Ditolak'],
        ];
    }
}
