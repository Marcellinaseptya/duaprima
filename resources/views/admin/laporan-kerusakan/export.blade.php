<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kerusakan Truk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Laporan Kerusakan Truk</h2>
    <h4>Jln. Tembus Mantuil No 11, Kelayan Selatan, Kec. Banjarmasin Selatan</h4>
    <p style="text-align: right">Tanggal Cetak: {{ $tanggalCetak }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Sopir</th>
                <th>Plat Truk</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporans as $index => $laporan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $laporan->sopir->user->nama ?? '-' }}</td>
                <td>{{ $laporan->mastertruk->plat_nomor ?? '-' }}</td>
                <td>{{ $laporan->deskripsi_kerusakan }}</td>
                <td>{{ $laporan->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
