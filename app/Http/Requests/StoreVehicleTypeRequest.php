<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Dikelola oleh middleware auth & role:admin di Route
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'unique:vehicle_types,name',
            ],
            'description' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tipe kendaraan wajib diisi.',
            'name.min' => 'Nama tipe kendaraan minimal 2 karakter.',
            'name.max' => 'Nama tipe kendaraan maksimal 100 karakter.',
            'name.unique' => 'Nama tipe kendaraan ini sudah terdaftar.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
        ];
    }
}