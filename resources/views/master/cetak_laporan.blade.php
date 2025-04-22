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
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        .no-print a.close {
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

<body>

    <h2>Laporan Keuangan</h2>

    <div class="periode">
        @if ($laporan->laporan_periodik == 'hari')
            <p>Tanggal: {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}</p>
        @elseif ($laporan->laporan_periodik == 'minggu')
            <p>Minggu: {{ \Carbon\Carbon::parse($laporan->tanggal)->startOfWeek()->translatedFormat('d F Y') }} -
                {{ \Carbon\Carbon::parse($laporan->tanggal)->endOfWeek()->translatedFormat('d F Y') }}</p>
        @elseif ($laporan->laporan_periodik == 'bulan')
            <p>Bulan: {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('F Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Keterangan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($transaksi as $i => $trx)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d-m-Y') }}</td>
                    <td>{{ $trx->keterangan }}</td>
                    <td>Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                </tr>
                @php $total += $trx->jumlah; @endphp
            @endforeach
            <tr class="total">
                <td colspan="3">Total</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->user_data->nama }}</p>
        <p>Tanggal Cetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <div class="no-print" style="text-align:center; margin-top: 30px;">
        <button class="print" onclick="window.print()">Print</button>
        <a href="{{ url('/laporan_keuangan') }}" class="close">Close</a>
    </div>

</body>

</html>
