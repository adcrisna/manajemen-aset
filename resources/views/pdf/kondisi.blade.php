<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Kondisi Data Aset</title>
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
        <h3>Laporan Kondisi Aset Nur Ihsan Islamic Full Day School</h3>
    </div>
    <center>
        <h3>Tahun {{ $baseYear }}</h3>
    </center>
    <div class="tableLaporan">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px">No</th>
                    <th style="width: 200px">Nama</th>
                    <th style="width: 80px">Jumlah</th>
                    <th style="width: 130px">Status</th>
                    <th style="width: 140">Harga Perolehan</th>
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
                        <td>{{ $value->jumlah }}</td>
                        <td>{{ $value->status }}</td>
                        <td>Rp.{{ number_format($value->harga_perolehan, 0, ',', '.') }}</td>
                        <td style="display: none">{{ $hargaPerolehan += $value->harga_perolehan }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"></td>
                    <td>Jumlah Aset Tetap (Bruto) </td>
                    <td>Rp.{{ number_format($hargaPerolehan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
