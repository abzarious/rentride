@csrf
<div class="space-y-4">
    <div>
        <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-2">Nama Brand <span class="text-red-500">*</span></label>
        <input type="text" 
               name="name" 
               id="name" 
               value="{{ old('name', $brand->name ?? '') }}" 
               placeholder="Contoh: Honda, Toyota, Yamaha" 
               class="w-full px-4 py-2.5 bg-slate-50 border @error('name') border-red-500 @else border-slate-300 @enderror rounded-xl text-slate-800 text-sm focus:bg-white focus:border-amber-500 focus:outline-none transition">
        @error('name')
            <p class="text-xs text-red-500 mt-1 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
        <a href="{{ route('admin.brands.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
            Batal
        </a>
        <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Data
        </button>
    </div>
</div>