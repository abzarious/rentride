@props(['status' => 'available'])

@php
    $classes = match(strtolower($status)) {
        'available' => 'bg-emerald-950 text-[#059669] border-emerald-600/40',
        'booked' => 'bg-amber-950 text-[#D97706] border-amber-600/40',
        'rented' => 'bg-blue-950 text-blue-400 border-blue-600/40',
        'maintenance' => 'bg-purple-950 text-purple-400 border-purple-600/40',
        'inactive' => 'bg-gray-800 text-gray-400 border-gray-600/40',
        default => 'bg-gray-800 text-gray-300 border-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => 'px-3 py-1 text-xs font-bold rounded-full border ' . $classes]) }}>
    {{ ucfirst($status) }}
</span>