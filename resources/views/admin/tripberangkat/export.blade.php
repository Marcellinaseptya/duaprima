<!DOCTYPE html>
<html>
<head>
    <title>Laporan Trip Berangkat</title>
    <style>
        body { font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan Trip Berangkat</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Sopir</th>
                <th>Truk</th>
                <th>Klien</th>
                <th>Tanggal</th>
                <th>Tujuan</th>
                <th>Makan</th>
                <th>Tol</th>
                <th>Parkir</th>
                <th>BBM</th>
                <th>Muatan Awal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $trip)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $trip->sopir->user->nama ?? '-' }}</td>
                <td>{{ $trip->mastertruk->plat_nomor ?? '-' }}</td>
                <td>{{ $trip->klien->nama_perusahaan ?? '-' }}</td>
                <td>{{ $trip->tanggal }}</td>
                <td>{{ $trip->lokasi_berangkat ?? '-' }}</td>
                <td>{{ number_format($trip->uang_makan_display) }}</td>
                <td>{{ number_format($trip->tripBerangkat->uang_tol ?? 0) }}</td>
                <td>{{ number_format($trip->tripBerangkat->uang_parkir ?? 0) }}</td>
                <td>{{ number_format($trip->harga_bbm_display) }}</td>
                <td>{{ number_format($trip->tripBerangkat->muatan_awal ?? 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
