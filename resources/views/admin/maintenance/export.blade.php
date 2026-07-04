<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Maintenance</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        .text-right { text-align: right; }
        .font-weight-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>CV. Dua Sejahtera Prima</h2>
        <p>Jln. Tembus Mantuil No 11, Kelayan Selatan, Kec. Banjarmasin Selatan</p>
        <h3>Laporan Maintenance</h3>
        @if(request('from') && request('to'))
            <p>Periode: {{ request('from') }} s/d {{ request('to') }}</p>
        @endif
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Truk (Plat)</th>
                <th>Kerusakan</th>
                <th>Tanggal Perbaikan</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($maintenances as $m)
                @php $total += $m->biaya_servis; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->mastertruk->plat_nomor ?? '-' }}</td>
                    <td>{{ $m->laporan->deskripsi_kerusakan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($m->tanggal_perbaikan)->format('d-m-Y') }}</td>
                    <td>Rp{{ number_format($m->biaya_servis, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="font-weight-bold">
                <td colspan="4" class="text-right">TOTAL BIAYA</td>
                <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
