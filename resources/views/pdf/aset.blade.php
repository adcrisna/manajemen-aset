<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Aset</title>
    <style>
        .titleLaporan {
            margin-left: 120px;
        }

        .tableLaporan {}

        table {
            border-collapse: collapse;
        }

        td {
            border: black 1x solid;
            padding: 5px;
            margin: 0px;
        }

        th {
            border: black 1x solid;
            padding: 5px;
            margin: 0px;
        }
    </style>
</head>

<body>
    <div class="titleLaporan">
        <h3>Laporan Pengadaan Aset Nur Ihsan Islamic Full Day School</h3>
    </div>
    <center>
        <h3>Tahun {{ $baseYear }}</h3>
    </center>
    <div class="tableLaporan">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Tanggal Pengadaan</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Harga Perolehan</th>
                    <th style="display: none">Total</th>
                </tr>
            </thead>
            @php
                $hargaPerolehan = 0;
            @endphp
            <tbody>
                @foreach ($aset as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $value->nama_aset }}</td>
                        <td>{{ $value->kategori }}</td>
                        <td>{{ $value->tanggal_pengadaan }}</td>
                        <td>{{ $value->jumlah }}</td>
                        <td>{{ $value->satuan }}</td>
                        <td>Rp.{{ number_format($value->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp.{{ number_format($value->harga_perolehan, 0, ',', '.') }}</td>
                        <td style="display: none">{{ $hargaPerolehan += $value->harga_perolehan }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6"></td>
                    <td>Jumlah Aset Tetap (Bruto) </td>
                    <td>Rp.{{ number_format($hargaPerolehan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
