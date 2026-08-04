@extends('layouts.customer')

@section('title', 'Form Booking - ' . $vehicle->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="mb-8">
        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="text-xs text-[#D97706] hover:underline mb-2 inline-block">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Detail Kendaraan
        </a>
        <h1 class="text-2xl font-extrabold text-white">Formulir Pemesanan Rental</h1>
        <p class="text-xs text-gray-400">Lengkapi tanggal sewa dan periksa estimasi biaya sebelum melakukan konfirmasi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        <div class="md:col-span-5">
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl sticky top-24">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Armada Yang Dipilih</h3>
                
                <div class="h-44 bg-gray-900 rounded-xl overflow-hidden border border-gray-800 mb-4">
                    @if($vehicle->thumbnail)
                        <img src="{{ asset('storage/' . $vehicle->thumbnail) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                            <i class="fa-solid fa-car text-4xl"></i>
                        </div>
                    @endif
                </div>

                <span class="text-[10px] font-bold text-[#D97706] uppercase">{{ $vehicle->brand->name }} &bull; {{ $vehicle->category->name }}</span>
                <h2 class="text-lg font-bold text-white mt-0.5">{{ $vehicle->name }}</h2>
                <p class="text-xs text-gray-400 mt-1"><i class="fa-solid fa-barcode mr-1"></i> Plat: {{ $vehicle->plate_number }}</p>

                <div class="mt-4 pt-4 border-t border-gray-800 flex justify-between items-center text-xs">
                    <span class="text-gray-400">Harga Sewa / Hari</span>
                    <span class="font-extrabold text-[#D97706] text-sm">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-7">
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl">
                
                @if($errors->any())
                    <x-alerts.alert type="danger" class="mb-6">
                        <ul class="list-disc pl-4 text-xs space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alerts.alert>
                @endif

                <form action="{{ route('customer.bookings.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    <div>
                        <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Tanggal & Waktu Mulai Rental</label>
                        <input type="datetime-local" name="start_date" id="start_date" 
                            value="{{ old('start_date', date('Y-m-d\TH:i')) }}" 
                            required 
                            class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Tanggal & Waktu Selesai Rental</label>
                        <input type="datetime-local" name="end_date" id="end_date" 
                            value="{{ old('end_date', date('Y-m-d\TH:i', strtotime('+1 day'))) }}" 
                            required 
                            class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Catatan Khusus (Opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Contoh: Pengambilan di Bandara jam 10 pagi..." 
                            class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">{{ old('notes') }}</textarea>
                    </div>

                    <div class="bg-[#030712] border border-gray-800 p-4 rounded-xl space-y-2 text-xs">
                        <div class="flex justify-between text-gray-400">
                            <span>Estimasi Durasi</span>
                            <span id="display_duration" class="font-bold text-white">1 Hari</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Tarif Per Hari</span>
                            <span class="font-bold text-white">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-extrabold pt-2 border-t border-gray-800 text-white">
                            <span>Total Pembayaran</span>
                            <span id="display_total" class="text-[#D97706] text-base">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#D97706] text-slate-950 font-extrabold rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20 text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Process Booking Now
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
    const pricePerDay = {{ $vehicle->price_per_day }};
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const displayDuration = document.getElementById('display_duration');
    const displayTotal = document.getElementById('display_total');

    function calculateTotal() {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);

        if (start && end && end > start) {
            const diffTime = Math.abs(end - start);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays < 1) diffDays = 1;

            const total = diffDays * pricePerDay;

            displayDuration.innerText = diffDays + " Hari";
            displayTotal.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(total);
        }
    }

    startDateInput.addEventListener('change', calculateTotal);
    endDateInput.addEventListener('change', calculateTotal);
</script>
@endsection