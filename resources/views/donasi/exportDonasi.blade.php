<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Export Semua Donasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body onload="window.print()">
    <h2>Data Donasi</h2>
    <p>Nama: {{ Auth::user()->user_data->nama }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donasi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d F Y', strtotime($item->tanggal)) }}</td>
                    <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->status_transaksi }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
                <td colspan="3"><strong>Rp {{ number_format($donasi->sum('jumlah'), 2, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
