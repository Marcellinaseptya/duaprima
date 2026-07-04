<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Truk</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }
        .logo {
            position: absolute;
            top: -10px;
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
    <p><strong>LAPORAN DATA TRUK</strong></p>
    <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sopir</th>
                <th>Perusahaan</th>
                <th>Plat Nomor</th>
                <th>Tarif</th>
                <th>BBM</th>
                <th>Netto (Kg)</th>
                <th>Harga Bersih</th>
                <th>Keuntungan Sopir</th>
                <th>Keuntungan Perusahaan</th>
                <th class="text-left">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($truks as $truk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($truk->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $truk->sopir->nama ?? '-' }}</td>
                    <td>{{ $truk->perusahaan }}</td>
                    <td>{{ $truk->mastertruk->plat_nomor ?? '-' }}</td>
                    <td>Rp{{ number_format($truk->tarif, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($truk->bbm, 0, ',', '.') }}</td>
                    <td>{{ number_format($truk->netto, 0, ',', '.') }} Kg</td>
                    <td>Rp{{ number_format($truk->harga_bersih, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($truk->keuntungan_sopir, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($truk->keuntungan_perusahaan, 0, ',', '.') }}</td>
                    <td class="text-left wrap-text">{{ $truk->keterangan }}</td>
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