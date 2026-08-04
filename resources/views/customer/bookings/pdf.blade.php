<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $booking->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { border-bottom: 2px solid #D97706; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .title { font-size: 20px; font-weight: bold; color: #111; }
        .badge { background: #eee; padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f4f4f4; }
        .total-box { margin-top: 20px; text-align: right; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">{{ $setting->company_name ?? 'RentRide' }}</div>
                    <div>{{ $setting->address ?? 'Malang, Jawa Timur' }} | WA: +{{ $setting->whatsapp ?? '6281234567890' }}</div>
                </td>
                <td style="text-align: right;">
                    <div style="font-size: 16px; font-weight: bold; color: #D97706;">INVOICE</div>
                    <div><strong>{{ $booking->invoice_number }}</strong></div>
                    <div>Tgl: {{ $booking->created_at->format('d/m/Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <strong>Penyewa (Customer):</strong><br>
                {{ $booking->user->name }}<br>
                Email: {{ $booking->user->email }}<br>
                Telp: {{ $booking->user->phone ?? '-' }}
            </td>
            <td style="width: 50%; vertical-align: top;">
                <strong>Status Pemesanan:</strong><br>
                <span class="badge">{{ strtoupper($booking->status) }}</span>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Deskripsi Armada</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>Durasi</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $booking->vehicle->name }}</strong><br>
                    Plat: {{ $booking->vehicle->plate_number }}
                </td>
                <td>{{ $booking->start_date->format('d/m/Y H:i') }}</td>
                <td>{{ $booking->end_date->format('d/m/Y H:i') }}</td>
                <td>{{ $booking->duration_days }} Hari</td>
                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-box">
        Total Pembayaran: <span style="color: #D97706;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
    </div>

    <div style="margin-top: 30px; font-size: 10px; color: #777; text-align: center; border-top: 1px solid #ddd; padding-top: 10px;">
        Terima kasih telah mempercayakan perjalanan Anda bersama {{ $setting->company_name ?? 'RentRide' }}.
    </div>

</body>
</html>