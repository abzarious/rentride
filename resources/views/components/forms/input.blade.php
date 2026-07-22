@props(['label' => null, 'name', 'type' => 'text', 'value' => '', 'placeholder' => ''])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-semibold text-gray-300 uppercase mb-2">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none transition']) }}>
    @error($name)
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>