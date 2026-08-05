<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $booking->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #2d3748; line-height: 1.4; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; }
        .header-table { width: 100%; border-bottom: 2px solid #D97706; padding-bottom: 12px; margin-bottom: 20px; }
        .company-name { font-size: 20px; font-weight: bold; color: #111827; }
        .invoice-title { font-size: 18px; font-weight: bold; color: #D97706; text-align: right; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { vertical-align: top; width: 50%; }
        .item-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .item-table th { background-color: #f3f4f6; border: 1px solid #e5e7eb; padding: 8px; text-align: left; font-size: 10px; uppercase; }
        .item-table td { border: 1px solid #e5e7eb; padding: 8px; }
        .summary-table { width: 40%; float: right; border-collapse: collapse; margin-bottom: 20px; }
        .summary-table td { padding: 5px 8px; }
        .total-row { font-weight: bold; font-size: 13px; color: #D97706; border-top: 2px solid #e5e7eb; }
        .clear { clear: both; }
        .footer { border-top: 1px solid #e5e7eb; padding-top: 12px; font-size: 9px; text-align: center; color: #718096; margin-top: 30px; }
        .badge { display: inline-block; padding: 3px 6px; background: #fef3c7; color: #92400e; font-size: 9px; font-weight: bold; border-radius: 4px; uppercase; }
    </style>
</head>
<body>

    <div class="invoice-box">
        
        <table class="header-table">
            <tr>
                <td>
                    <div class="company-name">{{ $setting->company_name ?? 'RentRide' }}</div>
                    <div>{{ $setting->address ?? 'Malang, Jawa Timur' }}</div>
                    <div>WhatsApp: +{{ $setting->whatsapp ?? '6281234567890' }} | Email: {{ $setting->email ?? 'info@rentride.id' }}</div>
                </td>
                <td style="text-align: right;">
                    <div class="invoice-title">INVOICE PEMESANAN</div>
                    <div><strong>No: {{ $booking->invoice_number }}</strong></div>
                    <div>Tgl Dibuat: {{ $booking->created_at->format('d/m/Y H:i') }} WIB</div>
                </td>
            </tr>
        </table>

        <table class="info-table">
            <tr>
                <td>
                    <strong>Ditujukan Kepada (Customer):</strong><br>
                    <strong>{{ $booking->user->name }}</strong><br>
                    Email: {{ $booking->user->email }}<br>
                    No. WA: {{ $booking->user->phone ?? '-' }}
                </td>
                <td style="text-align: right;">
                    <strong>Status Pemesanan:</strong><br>
                    <span class="badge">{{ strtoupper($booking->status) }}</span>
                </td>
            </tr>
        </table>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Deskripsi Kendaraan</th>
                    <th>Periode Rental</th>
                    <th>Durasi</th>
                    <th style="text-align: right;">Tarif / Hari</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $booking->vehicle->name }}</strong><br>
                        {{ $booking->vehicle->brand->name ?? '' }} &bull; Plat: {{ $booking->vehicle->plate_number }}
                    </td>
                    <td>
                        {{ $booking->start_date->format('d/m/Y H:i') }} WIB<br>
                        s/d {{ $booking->end_date->format('d/m/Y H:i') }} WIB
                    </td>
                    <td>{{ $booking->duration_days }} Hari</td>
                    <td style="text-align: right;">Rp {{ number_format($booking->price_per_day, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td>Subtotal Sewa:</td>
                <td style="text-align: right;">Rp {{ number_format($booking->subtotal ?? ($booking->price_per_day * $booking->duration_days), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Layanan Admin:</td>
                <td style="text-align: right;">+ Rp {{ number_format($booking->admin_fee ?? 5000, 0, ',', '.') }}</td>
            </tr>
            @if(($booking->discount ?? 0) > 0)
            <tr>
                <td>Diskon Promo:</td>
                <td style="text-align: right; color: green;">- Rp {{ number_format($booking->discount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Total Pembayaran:</td>
                <td style="text-align: right;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="clear"></div>

        <div style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 10px; border-radius: 6px; margin-top: 15px; font-size: 10px;">
            <strong>Instruksi Transfer Bank:</strong><br>
            Bank: <strong>{{ $setting->bank_name ?? 'BCA' }}</strong> | No. Rekening: <strong>{{ $setting->bank_number ?? '1234567890' }}</strong> a.n. <strong>{{ $setting->bank_holder ?? 'PT RentRide' }}</strong><br>
            <span style="color: #6b7280;">Setelah transfer, mohon konfirmasi bukti transfer melalui tombol WhatsApp di website.</span>
        </div>

        <div class="footer">
            Invoice ini diterbitkan secara otomatis oleh sistem {{ $setting->company_name ?? 'RentRide' }}. Bukti sah transaksi persewaan.
        </div>

    </div>

</body>
</html>