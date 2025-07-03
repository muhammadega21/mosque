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
                <th>Tanggal</th>
                <th>Transaksi Masuk</th>
                <th>Transaksi Keluar</th>
                <th>Kategori</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $total_masuk = 0;
                $total_keluar = 0;
                $no = 1;
            @endphp
            @foreach ($transaksi->sortBy('tanggal') as $i => $trx)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d-m-Y') }}</td>
                    @if ($trx->jenis_transaksi == 'keluar')
                        <td></td>
                        <td>Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                        @php
                            $total -= $trx->jumlah;
                            $total_keluar += $trx->jumlah;
                        @endphp
                    @else
                        <td>Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                        <td></td>
                        @php
                            $total += $trx->jumlah;
                            $total_masuk += $trx->jumlah;
                        @endphp
                    @endif
                    <td>{{ $trx->kategori->nama_kategori }}</td>
                    <td>{{ $trx->keterangan }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="2"></td>
                <td colspan="1">Rp {{ number_format($total_masuk, 0, ',', '.') }}</td>
                <td colspan="1">Rp {{ number_format($total_keluar, 0, ',', '.') }}</td>
                <td colspan="2">Total: Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->user_data->nama }}</p>
        <p>Tanggal Cetak: {{ now()->locale('id_ID')->translatedFormat('d F Y') }}</p>
    </div>

    <div class="no-print" style="text-align:center; margin-top: 30px;">
        <button class="print" onclick="window.print()">Print</button>
        <a href="{{ url()->previous() }}" class="back">Back</a>
    </div>

</body>

</html>
