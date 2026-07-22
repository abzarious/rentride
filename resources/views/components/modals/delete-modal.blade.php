@props(['id' => 'confirm-modal', 'title' => 'Konfirmasi Hapus', 'action' => '#'])

<div id="{{ $id }}" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-[#111827] border border-gray-800 p-6 rounded-2xl max-w-md w-full shadow-2xl">
        <h3 class="text-lg font-bold text-white mb-2">{{ $title }}</h3>
        <p class="text-xs text-gray-400 mb-6">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-3">
            <button onclick="document.getElementById('{{ $id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg text-xs font-semibold hover:bg-gray-700">
                Batal
            </button>
            <form action="{{ $action }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700">
                    Ya, Hapus Data
                </button>
            </form>
        </div>
    </div>
</div>