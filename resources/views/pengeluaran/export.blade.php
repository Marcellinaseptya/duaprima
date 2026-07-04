<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengeluaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .logo { position: absolute; top: -39px; left: 10px; width: 100px; }
        .header { text-align: center; margin-top: 10px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header small { font-size: 11px; }
        .garis { border-top: 3px solid #000; margin-top: 10px; margin-bottom: 15px; }
        .tanggal-cetak { text-align: left; font-size: 11px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th, td { border: 1px solid #000; padding: 5px; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .wrap-text { word-wrap: break-word; white-space: normal; max-width: 200px; }
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

    {{-- Tanggal Cetak --}}
    <div class="tanggal-cetak">
        Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>

    {{-- Judul --}}
    <h3 style="text-align: center; margin-bottom: 10px;">LAPORAN PENGELUARAN</h3>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Tanggal</th>
                <th class="text-left">Sumber</th>
                <th class="text-left">Nominal</th>
                <th class="text-left">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluarans as $pengeluaran)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d-m-Y') }}</td>
                <td class="text-left">{{ $pengeluaran->sumber }}</td>
                <td class="text-left">Rp{{ number_format($pengeluaran->nominal, 0, ',', '.') }}</td>
                <td class="text-left wrap-text">{{ $pengeluaran->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
    <tr>
        <th colspan="3" style="text-align:center">Total Pengeluaran</th>
        <th colspan="2" style="text-align:left">
            Rp{{ number_format($pengeluarans->sum('nominal'), 0, ',', '.') }}
        </th>
    </tr>
</tfoot>

    </table>

    {{-- Tanda tangan --}}
    <div style="text-align: right; margin-top: 50px;">
        <p>Banjarmasin, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <br><br><br>
        <p><strong>Masriani</strong><br>Owner</p>
    </div>

</body>
</html>
