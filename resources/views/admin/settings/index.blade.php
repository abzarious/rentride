@extends('layouts.admin')

@section('title', 'Pengaturan Website - ' . ($setting->company_name ?? 'RentRide'))
@section('page_title', 'Pengaturan Aplikasi & Sistem')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl text-sm font-medium flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl text-sm font-medium">
            <p class="font-bold mb-1"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Terjadi kesalahan pada form:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-amber-600"></i> Identitas Rental & Logo
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Atur nama rental, logo website, dan warna identitas aplikasi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Rental Website</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $setting->company_name) }}" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Logo Website</label>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl border border-slate-300 bg-slate-900 flex items-center justify-center overflow-hidden shrink-0">
                            @if($setting->logo)
                                <img id="logo-preview" src="{{ asset('storage/' . $setting->logo) }}" class="w-full h-full object-contain">
                            @else
                                <span id="logo-placeholder" class="text-amber-500 font-bold text-xl">
                                    <i class="fa-solid fa-car"></i>
                                </span>
                                <img id="logo-preview" class="w-full h-full object-contain hidden">
                            @endif
                        </div>
                        <input type="file" name="logo" id="logo-input" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Warna Utama (Dark Theme Background)</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="primary_color" value="{{ old('primary_color', $setting->primary_color ?? '#111827') }}"
                            class="w-12 h-10 rounded-lg cursor-pointer border border-slate-300 p-1">
                        <input type="text" value="{{ old('primary_color', $setting->primary_color ?? '#111827') }}" readonly
                            class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-xl text-xs font-mono text-slate-600">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Warna Aksen / Highlight (Gold/Bronze)</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="secondary_color" value="{{ old('secondary_color', $setting->secondary_color ?? '#D97706') }}"
                            class="w-12 h-10 rounded-lg cursor-pointer border border-slate-300 p-1">
                        <input type="text" value="{{ old('secondary_color', $setting->secondary_color ?? '#D97706') }}" readonly
                            class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-xl text-xs font-mono text-slate-600">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-emerald-600"></i> Kontak & WhatsApp Admin
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Nomor ini digunakan untuk konfirmasi otomatis pemesanan pelanggan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nomor WhatsApp Admin</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $setting->whatsapp) }}" placeholder="6281234567890" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <p class="text-[10px] text-slate-400 mt-1">Gunakan format angka awal 62 atau 08.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nomor Telepon Kantor</label>
                    <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}" placeholder="081234567890"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Email Official</label>
                    <input type="email" name="email" value="{{ old('email', $setting->email) }}" placeholder="info@rental.com"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Alamat Lengkap Garasi / Rental</label>
                    <textarea name="address" rows="3"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('address', $setting->address) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-building-columns text-blue-600"></i> Rekening Bank Pembayaran
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Informasi rekening transfer manual yang ditampilkan pada invoice pelanggan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Bank</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $setting->bank_name) }}" placeholder="Contoh: BCA / Mandiri"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nomor Rekening</label>
                    <input type="text" name="bank_number" value="{{ old('bank_number', $setting->bank_number) }}" placeholder="1234567890"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Atas Nama Rekening</label>
                    <input type="text" name="bank_holder" value="{{ old('bank_holder', $setting->bank_holder) }}" placeholder="PT RentRide Indonesia"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button type="submit" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-amber-600/20 flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Seluruh Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
    // Live Image Preview (Programmer C)
    document.getElementById('logo-input').addEventListener('change', function(e) {
        const preview = document.getElementById('logo-preview');
        const placeholder = document.getElementById('logo-placeholder');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection