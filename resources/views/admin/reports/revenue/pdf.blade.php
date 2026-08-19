<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan - {{ $setting->company_name ?? 'RentRide' }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #334155;
            margin: 0;
            padding: 0;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #cbd5e1;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .header table {
            width: 100%;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
        }
        .report-title {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            color: #d97706;
            text-transform: uppercase;
        }
        .meta-info {
            margin-bottom: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px;
            border-radius: 6px;
        }
        .meta-info table {
            width: 100%;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-data th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 6px;
            border: 1px solid #0f172a;
        }
        .table-data td {
            padding: 7px 6px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .table-data tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .total-box {
            margin-top: 15px;
            text-align: right;
            font-size: 12px;
        }
        .total-amount {
            font-size: 16px;
            font-weight: bold;
            color: #059669;
        }
        .footer {
            margin-top: 30px;
            width: 100%;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="company-name">{{ $setting->company_name ?? 'RentRide' }}</div>
                    <div style="font-size: 10px; color: #64748b; mt-1;">
                        {{ $setting->address ?? 'Sistem Persewaan Mobil & Motor Eksekutif' }}<br>
                        Telp/WA: +{{ $setting->whatsapp ?? '6281234567890' }} | Email: {{ $setting->email ?? 'info@rentride.id' }}
                    </div>
                </td>
                <td class="report-title">
                    Laporan Pendapatan<br>
                    <span style="font-size: 9px; color: #64748b; font-weight: normal;">Dicetak: {{ date('d M Y, H:i') }} WIB</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td><strong>Dicetak Oleh:</strong> {{ auth()->user()->name }} (Admin)</td>
                <td class="text-right">
                    <strong>Periode Filter:</strong>
                    @if(!empty($filters['start_date']) || !empty($filters['end_date']))
                        {{ $filters['start_date'] ?? 'Awal' }} s/d {{ $filters['end_date'] ?? 'Sekarang' }}
                    @elseif(!empty($filters['month']))
                        Bulan {{ \Carbon\Carbon::create()->month((int)$filters['month'])->translatedFormat('F') }} {{ $filters['year'] ?? date('Y') }}
                    @else
                        Keseluruhan Data
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 18%;">NO. INVOICE</th>
                <th style="width: 22%;">CUSTOMER</th>
                <th style="width: 23%;">KENDARAAN</th>
                <th style="width: 17%;">TGL BAYAR</th>
                <th style="width: 15%; text-align: right;">NOMINAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $index => $payment)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold" style="color: #d97706;">{{ $payment->booking->invoice_number ?? '-' }}</td>
                    <td>
                        <div class="font-bold">{{ $payment->booking->user->name ?? '-' }}</div>
                        <div style="color: #64748b; font-size: 9px;">{{ $payment->booking->user->email ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="font-bold">{{ $payment->booking->vehicle->name ?? '-' }}</div>
                        <div style="color: #64748b; font-size: 9px;">Plat: {{ $payment->booking->vehicle->plate_number ?? '-' }}</div>
                    </td>
                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-right font-bold" style="color: #059669;">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Tidak ada transaksi pendapatan terverifikasi pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        <span>TOTAL PENDAPATAN DITERIMA: </span>
        <span class="total-amount">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
    </div>

    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td>Dokumen ini dihasilkan secara otomatis oleh sistem {{ $setting->company_name ?? 'RentRide' }}.</td>
                <td class="text-right">Halaman 1 dari 1</td>
            </tr>
        </table>
    </div>

</body>
</html>