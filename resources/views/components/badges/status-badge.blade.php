@props(['status' => 'available'])

@php
    // 1. Ekstrak nilai string dari Enum jika $status berupa BackedEnum
    $statusValue =$status instanceof \BackedEnum ? $status->value : (string)$status;
    $statusString = strtolower(trim($statusValue));

    // 2. Pemetaan Warna Tailwind untuk Status Kendaraan & Status Booking
    $classes = match($statusString) {
        // Status Booking / Transaksi
        'pending'     => 'bg-amber-500/10 text-amber-500 border-amber-500/30',
        'approved'    => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/30',
        'ongoing'     => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/30',
        'completed'   => 'bg-blue-500/10 text-blue-400 border-blue-500/30',
        'rejected'    => 'bg-red-500/10 text-red-500 border-red-500/30',
        'cancelled'   => 'bg-rose-500/10 text-rose-400 border-rose-500/30',

        // Status Master Kendaraan
        'available'   => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/30',
        'booked'      => 'bg-amber-500/10 text-amber-500 border-amber-500/30',
        'rented'      => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/30',
        'maintenance' => 'bg-purple-500/10 text-purple-400 border-purple-500/30',
        'inactive'    => 'bg-gray-500/10 text-gray-400 border-gray-500/30',

        default       => 'bg-gray-500/10 text-gray-400 border-gray-500/30',
    };

    // 3. Icon FontAwesome Sesuai Status
    $icon = match($statusString) {
        'pending'     => 'fa-clock',
        'approved'    => 'fa-circle-check',
        'ongoing'     => 'fa-key',
        'completed'   => 'fa-flag-checkered',
        'rejected'    => 'fa-circle-xmark',
        'cancelled'   => 'fa-ban',
        'available'   => 'fa-check',
        'booked'      => 'fa-bookmark',
        'rented'      => 'fa-car-side',
        'maintenance' => 'fa-wrench',
        'inactive'    => 'fa-eye-slash',
        default       => 'fa-info-circle',
    };

    // 4. Custom Label Teks
    $labels = [
        'pending'     => 'Menunggu WA',
        'approved'    => 'Disetujui',
        'ongoing'     => 'Sedang Dirental',
        'completed'   => 'Selesai',
        'rejected'    => 'Ditolak',
        'cancelled'   => 'Dibatalkan',
        'available'   => 'Tersedia',
        'booked'      => 'Dibooking',
        'rented'      => 'Sedang Dirental',
        'maintenance' => 'Perbaikan',
        'inactive'    => 'Nonaktif',
    ];

    $displayLabel =$labels[$statusString] ?? ucfirst($statusString);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full border ' .$classes]) }}>
    <i class="fa-solid {{ $icon }} text-[10px]"></i>
    <span>{{ $displayLabel }}</span>
</span>