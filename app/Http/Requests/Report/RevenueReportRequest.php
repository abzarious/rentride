<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class RevenueReportRequest extends FormRequest
{
    /**
     * Memastikan hanya user login (Admin) yang dapat melakukan request laporan.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi input filter laporan.
     */
    public function rules(): array
    {
        return [
            'start_date' => [
                'nullable',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'month' => [
                'nullable',
                'integer',
                'between:1,12',
            ],
            'year' => [
                'nullable',
                'integer',
                'between:2020,2100',
            ],
        ];
    }

    /**
     * Pesan error kustom bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.',
            'month.between'           => 'Pilihan bulan tidak valid.',
            'year.between'            => 'Pilihan tahun harus antara 2020 hingga 2100.',
        ];
    }
}