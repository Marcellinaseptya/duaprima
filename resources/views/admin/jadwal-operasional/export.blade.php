<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Jadwal Operasional</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>

<h3 style="text-align:center;">Laporan Jadwal Operasional</h3>
<p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal & Jam</th>
            <th>Nama Sopir</th>
            <th>Plat Truk</th>
            <th>Tujuan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jadwals as $i => $jadwal)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y, H:i') }}</td>
                <td>{{ $jadwal->sopir->user->nama ?? '-' }}</td>
                <td>{{ $jadwal->truk->plat_nomor ?? $jadwal->plat_nomor ?? '-' }}</td>
                <td>{{ $jadwal->tujuan }}</td>
                <td>{{ $jadwal->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
