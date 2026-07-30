<footer class="bg-[#111827] border-t border-gray-800 pt-12 pb-8 mt-12 text-gray-400 text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-3">
                @if($setting->logo ?? false)
                    <img src="{{ asset('storage/' . $setting->logo) }}" class="h-7 w-auto object-contain">
                @endif
                <span class="text-lg font-bold text-white tracking-wider">{{ $setting->company_name ?? 'RentRide' }}</span>
            </div>
            <p class="text-xs leading-relaxed text-gray-400">
                Layanan persewaan mobil dan motor eksekutif dengan armada terawat, respon WhatsApp instan, dan proses pemesanan mudah.
            </p>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-3">Layanan</h4>
            <ul class="space-y-2 text-xs">
                <li><a href="#" class="hover:text-[#D97706]">Sewa Mobil Harian</a></li>
                <li><a href="#" class="hover:text-[#D97706]">Sewa Motor Matic & Sport</a></li>
                <li><a href="#" class="hover:text-[#D97706]">Lepas Kunci</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-3">Bantuan & Kontak</h4>
            <p class="text-xs text-gray-400 mb-2">
                <a href="https://wa.me/{{ $setting->whatsapp ?? '6281234567890' }}" target="_blank" class="hover:text-[#059669]">
                    <i class="fa-brands fa-whatsapp text-[#059669] mr-2"></i> +{{ $setting->whatsapp ?? '6281234567890' }}
                </a>
            </p>
            <p class="text-xs text-gray-400 mb-2">
                <i class="fa-regular fa-envelope text-[#D97706] mr-2"></i> {{ $setting->email ?? 'info@rentride.id' }}
            </p>
            <p class="text-xs text-gray-400 leading-relaxed">
                <i class="fa-solid fa-location-dot text-red-500 mr-2"></i> {{ $setting->address ?? 'Malang, Jawa Timur' }}
            </p>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-3">Rekening Pembayaran</h4>
            <p class="text-xs leading-relaxed mb-2 text-white font-medium">
                {{ $setting->bank_name ?? 'BCA' }}: <span class="text-[#D97706]">{{ $setting->bank_number ?? '1234567890' }}</span>
            </p>
            <p class="text-[11px] text-gray-400 mb-3">a.n. {{ $setting->bank_holder ?? 'PT RentRide' }}</p>
            <span class="inline-block px-3 py-1 bg-emerald-950 border border-emerald-600 text-[#059669] text-xs font-semibold rounded-full">
                <i class="fa-solid fa-shield-halved mr-1"></i> Verifikasi WA Cepat
            </span>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-800/80 pt-6 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} {{ $setting->company_name ?? 'RentRide' }} Premium Rental System. All rights reserved.
    </div>
</footer>