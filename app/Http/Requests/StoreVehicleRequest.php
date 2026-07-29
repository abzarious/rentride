<?php

namespace App\Http\Requests;

use App\Enums\VehicleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan admin memproses request
    }

    public function rules(): array
    {
        return [
            'brand_id'        => ['required', 'exists:brands,id'],
            'category_id'     => ['required', 'exists:vehicle_categories,id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'name'            => ['required', 'string', 'max:255'],
            'plate_number'    => ['required', 'string', 'max:20', 'unique:vehicles,plate_number'],
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
        return [
            'brand_id.required'        => 'Brand kendaraan wajib dipilih.',
            'category_id.required'     => 'Kategori kendaraan wajib dipilih.',
            'vehicle_type_id.required' => 'Tipe kendaraan wajib dipilih.',
            'name.required'            => 'Nama kendaraan wajib diisi.',
            'plate_number.required'    => 'Plat nomor wajib diisi.',
            'plate_number.unique'      => 'Plat nomor ini sudah terdaftar di sistem.',
            'year.required'            => 'Tahun pembuatan wajib diisi.',
            'year.digits'              => 'Tahun harus berupa 4 digit angka (contoh: 2024).',
            'color.required'           => 'Warna kendaraan wajib diisi.',
            'price_per_day.required'   => 'Harga sewa per hari wajib diisi.',
            'price_per_day.integer'    => 'Harga sewa harus berupa angka tanpa titik atau koma.',
            'transmission.required'    => 'Jenis transmisi wajib dipilih.',
            'fuel_type.required'       => 'Jenis bahan bakar wajib dipilih.',
            'status.required'          => 'Status kendaraan wajib dipilih.',
            'thumbnail.image'          => 'File thumbnail harus berupa gambar.',
            'thumbnail.max'            => 'Ukuran foto maksimal 2MB.',
        ];
    }
}