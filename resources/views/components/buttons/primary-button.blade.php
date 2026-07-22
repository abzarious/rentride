@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'px-5 py-2.5 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20 text-sm flex items-center justify-center gap-2']) }}>
    {{ $slot }}
</button>