<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 30px;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .periode {
            text-align: center;
            margin-top: 20px;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;

        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        .total {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .footer p {
            margin-bottom: 0;
        }

        .no-print button,
        a {
            background: none;
            border: none;
            outline: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .no-print button.print {
            background-color: #007bff;
        }

        .no-print a.back {
            background-color: #dc3545;
            text-decoration: none
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <h2>Laporan Keuangan Masjid Al-Hamujirin</h2>

    <div class="periode">
        @if ($laporan->laporan_periodik == 'hari')
            <p>Tanggal: {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}</p>
        @elseif ($laporan->laporan_periodik == 'minggu')
            <p>Minggu: {{ \Carbon\Carbon::parse($laporan->tanggal)->startOfWeek()->translatedFormat('d F Y') }} -
                {{ \Carbon\Carbon::parse($laporan->tanggal)->endOfWeek()->translatedFormat('d F Y') }}</p>
        @elseif ($laporan->laporan_periodik == 'bulan')
            <p>Bulan: {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('F Y') }}</p>
        @endif
        <p>Tanggal Cetak : {{ now()->locale('id_ID')->translatedFormat('d F Y') }}</p>
    </div>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kas Masuk (Rp)</th>
                <th>Kas Keluar (Rp)</th>
                <th>Total (Rp)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $total_masuk = 0;
                $total_keluar = 0;
                $no = 1;
                $saldo = 0;
            @endphp
            @foreach ($transaksi->sortBy('tanggal') as $i => $trx)
                @php
                    if ($trx->jenis_kas == 'kas masuk') {
                        $saldo += $trx->jumlah;
                        $total_masuk += $trx->jumlah;
                    } else {
                        $saldo -= $trx->jumlah;
                        $total_keluar += $trx->jumlah;
                    }
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d-m-Y') }}</td>
                    @if ($trx->jenis_kas == 'kas keluar')
                        <td>-</td>
                        <td>{{ $trx->jumlah }}</td>
                    @else
                        <td>{{ $trx->jumlah }}</td>
                        <td>-</td>
                    @endif
                    <td>{{ $saldo }}</td>
                    <td>{{ $trx->keterangan }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="4">Total</td>
                <td colspan="2">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: Pengurus</p>
    </div>

    <div class="no-print" style="text-align:center; margin-top: 30px;">
        <button class="print" onclick="window.print()">Print</button>
        <a href="{{ url()->previous() }}" class="back">Back</a>
    </div>

</body>

</html>
