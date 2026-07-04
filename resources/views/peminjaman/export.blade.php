<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
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
        Tanggal Cetak: {{ $tanggalCetak }}
    </div>

    {{-- Judul --}}
    <h3 style="text-align: center; margin-bottom: 10px;">LAPORAN PEMINJAMAN</h3>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Tanggal</th>
                <th class="text-left">Sumber</th>
                <th class="text-left">Nominal</th>
                <th class="text-left">Terbayar</th>
                <th class="text-left">Status</th>
                <th class="text-left">Sopir</th>
                <th class="text-left">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td class="text-left">{{ $item->sumber }}</td>
                <td class="text-left">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td class="text-left">Rp{{ number_format($item->terbayar ?? 0, 0, ',', '.') }}</td>
                <td class="text-left">
                    {{ $item->status_pelunasan }}
                </td>
                <td class="text-left">{{ $item->sopir->nama ?? '-' }}</td>
                <td class="text-left wrap-text">{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:center">Total Peminjaman</th>
                <th style="text-align:left">Rp{{ number_format($totalPinjaman, 0, ',', '.') }}</th>
                <th colspan="4" style="text-align:left">Total Terbayar: Rp{{ number_format($totalTerbayar, 0, ',', '.') }}</th>
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
