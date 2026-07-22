@props(['type' => 'success'])

@php
    $styles = match($type) {
        'success' => 'bg-emerald-950/80 border-emerald-600 text-[#059669]',
        'danger' => 'bg-red-950/80 border-red-600 text-red-400',
        'warning' => 'bg-amber-950/80 border-amber-600 text-[#D97706]',
        default => 'bg-blue-950/80 border-blue-600 text-blue-400',
    };
@endphp

<div {{ $attributes->merge(['class' => 'p-4 rounded-xl border text-sm flex items-center gap-3 ' . $styles]) }}>
    <i class="fa-solid fa-circle-info text-lg"></i>
    <div>{{ $slot }}</div>
</div>