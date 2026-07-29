<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicle_categories', 'name')->ignore($this->vehicle_category),
            ],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah digunakan oleh kategori lain.',
            'status.required' => 'Status kategori wajib dipilih.',
        ];
    }
}