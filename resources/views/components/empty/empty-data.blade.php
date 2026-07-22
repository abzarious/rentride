@props(['title' => 'Data Tidak Ditemukan', 'description' => 'Belum ada data yang tersedia saat ini.'])

<div class="p-12 text-center bg-[#111827] rounded-2xl border border-gray-800 my-4">
    <div class="w-16 h-16 bg-gray-800/80 text-gray-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
        <i class="fa-solid fa-folder-open"></i>
    </div>
    <h4 class="text-base font-bold text-white mb-1">{{ $title }}</h4>
    <p class="text-xs text-gray-400 max-w-sm mx-auto mb-4">{{ $description }}</p>
    {{ $slot }}
</div>