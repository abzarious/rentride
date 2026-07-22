@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg text-sm flex items-center justify-center gap-2']) }}>
    {{ $slot }}
</button>