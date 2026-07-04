<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Nota Hauling</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 70px;
        }
        .header {
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .header small {
            font-size: 12px;
        }
        .garis {
            border-top: 2px solid #000;
            margin: 20px 0 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            vertical-align: top;
        }
        .text-left {
            text-align: left;
        }
        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body>

    {{-- Logo --}}
    <img src="{{ public_path('images/logo.png') }}" class="logo">

    {{-- Header --}}
    <div class="header">
        <h2>CV. DUA SAHABAT PRIMA</h2>
        <small>Jln. Tembus Mantuil No 11, Kelayan Selatan, Kec. Banjarmasin Selatan</small>
    </div>

    <div class="garis"></div>

    {{-- Judul --}}
    <p><strong>LAPORAN NOTA HAULING</strong></p>
    <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sopir</th>
                <th>Tarif per Rit</th>
                <th>Jumlah Ritase</th>
                <th>Total Pemasukan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notas as $nota)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $nota->sopir->nama ?? '-' }}</td>
                    <td>Rp{{ number_format($nota->tarif_per_rit, 0, ',', '.') }}</td>
                    <td>{{ $nota->jumlah_ritase }}</td>
                    <td>Rp{{ number_format($nota->tarif_per_rit * $nota->jumlah_ritase, 0, ',', '.') }}</td>
                    <td class="text-left wrap-text">{{ $nota->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer Tanda Tangan --}}
    <div class="footer">
        <p>Banjarmasin, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <br><br><br>
        <p><strong>Masriani</strong><br>Owner</p>
    </div>

</body>
</html>
