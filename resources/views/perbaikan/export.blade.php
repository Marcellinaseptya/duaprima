<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perbaikan Truk</title>
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
        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
        img.foto {
            width: 80px;
            height: auto;
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
    <p><strong>LAPORAN PERBAIKAN TRUK</strong></p>
    <p><strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}</p>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Sopir</th>
                <th>Plat Truk</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perbaikans as $perbaikan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($perbaikan->tanggal_perbaikan)->format('d-m-Y') }}</td>
                    <td>{{ $perbaikan->sopir->nama ?? '-' }}</td>
                    <td>{{ $perbaikan->truk->plat_nomor ?? '-' }}</td>
                    <td class="wrap-text">{{ $perbaikan->keluhan }}</td>
                    <td>{{ $perbaikan->status }}</td>
                    <td>
                        @if ($perbaikan->foto && file_exists(public_path($perbaikan->foto)))
                            <img src="{{ public_path($perbaikan->foto) }}" class="foto">
                        @else
                            Tidak ada
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer Tanda Tangan --}}
    <div class="footer">
        <p>Banjarmasin, {{ $tanggalCetak }}</p>
        <br><br><br>
        <p><strong>Masriani</strong><br>Owner</p>
    </div>

</body>
</html>