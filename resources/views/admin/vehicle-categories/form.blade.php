@csrf
<div class="space-y-4">
    <div>
        <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-2">Nama Kategori <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" placeholder="Contoh: Mobil, Motor, Sepeda Listrik" 
            class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:bg-white focus:outline-none transition @error('name') border-red-500 @enderror" required>
        @error('name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block text-xs font-semibold text-slate-700 uppercase mb-2">Status <span class="text-red-500">*</span></label>
        <select name="status" id="status" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:bg-white focus:outline-none transition @error('status') border-red-500 @enderror">
            <option value="1" {{ old('status', $category->status ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('status', $category->status ?? 1) == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
        @error('status')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 mt-6">
    <a href="{{ route('admin.vehicle-categories.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
        Batal
    </a>
    <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl transition shadow-md shadow-amber-600/20 flex items-center gap-2">
        <i class="fa-solid fa-save"></i> Simpan Data
    </button>
</div>