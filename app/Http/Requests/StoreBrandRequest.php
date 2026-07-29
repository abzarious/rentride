<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:brands,name',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama brand wajib diisi.',
            'name.string'   => 'Nama brand harus berupa teks.',
            'name.max'      => 'Nama brand maksimal 100 karakter.',
            'name.unique'   => 'Nama brand tersebut sudah terdaftar.',
        ];
    }
}