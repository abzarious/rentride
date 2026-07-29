<?php

namespace App\Http\Requests;

use App\Enums\VehicleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id'        => ['required', 'exists:brands,id'],
            'category_id'     => ['required', 'exists:vehicle_categories,id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'name'            => ['required', 'string', 'max:255'],
            'plate_number'    => ['required', 'string', 'max:20', Rule::unique('vehicles', 'plate_number')->ignore($this->vehicle)],
            'year'            => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'color'           => ['required', 'string', 'max:50'],
            'price_per_day'   => ['required', 'integer', 'min:0'],
            'transmission'    => ['required', 'in:Automatic,Manual'],
            'fuel_type'       => ['required', 'in:Bensin,Diesel,Listrik'],
            'status'          => ['required', new Enum(VehicleStatus::class)],
            'thumbnail'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description'     => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return (new StoreVehicleRequest())->messages();
    }
}