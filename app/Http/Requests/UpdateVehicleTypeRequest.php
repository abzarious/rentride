<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vehicleTypeId = $this->route('vehicle_type')->id ?? $this->route('vehicle_type');

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('vehicle_types', 'name')->ignore($vehicleTypeId),
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
            'name.unique' => 'Nama tipe kendaraan ini sudah digunakan.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
        ];
    }
}