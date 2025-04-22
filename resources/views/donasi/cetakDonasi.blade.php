<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Donasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .faktur {
            max-width: 600px;
            margin: auto;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="faktur">
        <div style="text-align: center; margin-bottom: 20px; color: #2A541A;">
            <h2>Bukti Donasi</h2>
        </div>
        <p>Yang bertanda tangan dibawah ini:</p>
        <div>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $transaksi->user->user_data->nama }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $transaksi->user->user_data->alamat }}</td>
                </tr>
                <tr>
                    <td>Telepon</td>
                    <td>: {{ $transaksi->user->user_data->nomor_hp }}</td>
                </tr>
            </table>
        </div>
        <p><strong>Telah melakukan donasi sebesar</strong></p>
        <div>
            <table border="1"
                style="width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid #000;">
                <thead>
                    <tr>
                        <th style="text-align: left;">No</th>
                        <th style="text-align: left;">Tanggal</th>
                        <th style="text-align: left;">Keterangan</th>
                        <th style="text-align: left;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: left;">1</td>
                        <td style="text-align: left;">{{ date('d F Y', strtotime($transaksi->tanggal)) }}</td>
                        <td style="text-align: left;">{{ $transaksi->keterangan }}</td>
                        <td style="text-align: left;">Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</td>

                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">Total:</td>
                        <td style="text-align: left;">Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p><strong>Demikian bukti donasi ini berlaku sebagai bukti yang sah.</strong></p>
        <p style="text-align: right; margin-top: 50px;">{{ date('d F Y') }}</p>
        <p style="text-align: right;">{{ Auth::user()->user_data->nama }}</p>
    </div>
</body>

</html>
