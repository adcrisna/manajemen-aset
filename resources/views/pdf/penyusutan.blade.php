<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Penyusutan</title>
    <style>
        .tableLaporan {}

        table {
            border-collapse: collapse;
        }

        td {
            padding: 5px;
            margin: 0px;
            font-size: 12px;
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
        <center>
            <h3>
                Nur Ihsan Islamic Full Day School <br>
            </h3>
            <h2>Neraca</h2>
            <h3>Per {{ $tahun }}</h3>
        </center>
    </div>
    <div class="tableLaporan">
        <table>
            <thead>
                <tr>
                    <th style="width: 330px">Uraian</th>
                    <th style="width: 330px">Tahun {{ $baseYear }}</th>
                </tr>
            </thead>
            <tbody style="border: 2px black solid">
                <tr>
                    <td>Aset Tetap :</td>
                    <td style="border-left: black 2px solid"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-left: black 2px solid"></td>
                </tr>
                @php
                    $hargaPerolehan = 0;
                    $penyusutanPertahun = 0;
                    $sisaNilaiPenyusutan = 0;
                @endphp
                @foreach ($penyusutan as $key => $value)
                    <tr>
                        <td>{{ $value->nama_aset }}</td>
                        <td style="border-left: black 2px solid">
                            Rp.{{ number_format($value->sisa_nilai_penyusutan[$baseYear] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr style="display: none">
                        <td>
                            {{ $hargaPerolehan += $value->harga_perolehan }}
                            {{ $penyusutanPertahun += $value->penyusutan_pertahun }}
                            {{ $sisaNilaiPenyusutan += $value->sisa_nilai_penyusutan[$baseYear] ?? 0 }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td style="border-left: black 2px solid"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Jumlah Aset Tetap (Bruto)</td>
                    <td style="border-left: black 2px solid; font-weight: bold">Rp.
                        {{ number_format($hargaPerolehan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Akumulasi Penyusutan Aset Tetap</td>
                    <td style="border-left: black 2px solid; font-weight: bold">Rp.
                        {{ number_format($penyusutanPertahun, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Jumlah Aset Tetap</td>
                    <td style="border-left: black 2px solid; font-weight: bold">Rp.
                        {{ number_format($sisaNilaiPenyusutan, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
