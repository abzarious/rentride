@props(['status'])

@php
    // Konversi status baik bertipe Enum maupun String
    $statusValue = match(true) {
        $status instanceof \App\Enums\VehicleStatus => $status->value,
        is_object($status) && property_exists($status, 'value') => $status->value,
        default => (string) $status,
    };

    $statusValue = strtolower($statusValue);

    // Styling Badge Tailwind berdasarkan Status
    $badgeClasses = match($statusValue) {
        'available', 'approved', 'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'booked', 'pending'                   => 'bg-amber-100 text-amber-700 border-amber-200',
        'rented', 'ongoing'                  => 'bg-blue-100 text-blue-700 border-blue-200',
        'maintenance'                        => 'bg-purple-100 text-purple-700 border-purple-200',
        'rejected', 'cancelled', 'inactive'  => 'bg-red-100 text-red-700 border-red-200',
        default                              => 'bg-slate-100 text-slate-600 border-slate-200',
    };

    // Label Bahasa Indonesia
    $labels = [
        'available'   => 'Tersedia',
        'booked'      => 'Dibooking',
        'rented'      => 'Sedang Dirental',
        'ongoing'     => 'Sedang Dirental',
        'maintenance' => 'Perbaikan',
        'inactive'    => 'Nonaktif',
        'pending'     => 'Menunggu Verifikasi',
        'approved'    => 'Disetujui',
        'rejected'    => 'Ditolak',
        'completed'   => 'Selesai',
        'cancelled'   => 'Dibatalkan',
    ];

    $label = $labels[$statusValue] ?? ucfirst($statusValue);
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $badgeClasses }}">
    {{ $label }}
</span>