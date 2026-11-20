<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota #RNT-{{ str_pad($rental->id_rental, 3, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        body {
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .nota-box {
            background: #ffffff;
            width: 340px;
            /* Pas untuk kertas 80mm / nota ringkas */
            padding: 20px;
            border: 1px dashed #cbd5e1;
            color: #0f172a;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #64748b;
            margin: 12px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        td {
            padding: 4px 0;
            vertical-align: top;
        }

        .status-stamp {
            display: inline-block;
            border: 2px solid #15803d;
            color: #15803d;
            padding: 3px 10px;
            font-weight: bold;
            font-size: 12px;
            margin-top: 8px;
        }

        .status-unpaid {
            border-color: #b45309;
            color: #b45309;
        }

        .no-print {
            margin-bottom: 16px;
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: sans-serif;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-print {
            background: #2563eb;
            color: #fff;
        }

        .btn-back {
            background: #e2e8f0;
            color: #334155;
        }

        /* Pengaturan khusus saat dicetak */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .nota-box {
                border: none;
                width: 100%;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body onload="window.print()">

    {{-- Tombol Navigasi (Otomatis hilang saat diprint) --}}
    <div class="no-print">
        <a href="{{ route('payment.index') }}" class="btn btn-back">Kembali</a>
        <button onclick="window.print()" class="btn btn-print">Cetak Nota</button>
    </div>

    {{-- Isi Nota --}}
    <div class="nota-box">
        <div class="text-center">
            <div class="fw-bold" style="font-size: 16px;">RENTAL MOBIL</div>
            <div style="font-size: 12px;">Jl. Slamet Riyadi No. 123, Surakarta</div>
            <div style="font-size: 12px;">Telp: 0812-3456-7890</div>
        </div>

        <div class="divider"></div>

        <table>
            <tr>
                <td>No. Nota</td>
                <td class="text-right fw-bold">#RNT-{{ str_pad($rental->id_rental, 3, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td class="text-right">{{ $rental->customer->nama_customer ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td class="text-right">{{ $rental->customer->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tgl Bayar</td>
                <td class="text-right">
                    {{ $rental->payment?->tgl_pembayaran ? \Carbon\Carbon::parse($rental->payment->tgl_pembayaran)->format('d/m/Y') : '-' }}
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table>
            <tr>
                <td colspan="2" class="fw-bold">{{ $rental->car->nama_mobil ?? '-' }} ({{ $rental->car->plat_nomor ?? '-' }})</td>
            </tr>
            <tr>
                <td>Mulai Sewa</td>
                <td class="text-right">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td>Selesai Sewa</td>
                <td class="text-right">{{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <table>
            <tr class="fw-bold" style="font-size: 15px;">
                <td>TOTAL</td>
                <td class="text-right">Rp {{ number_format($rental->payment->total ?? $rental->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="text-center">
            @if ($rental->payment && $rental->payment->status === 'paid')
            <div class="status-stamp">LUNAS</div>
            @else
            <div class="status-stamp status-unpaid">BELUM TERBAYAR</div>
            @endif
        </div>

        <div class="divider"></div>

        <div class="text-center" style="font-size: 12px;">
            Terima kasih atas kepercayaan Anda!
        </div>
    </div>

</body>

</html>