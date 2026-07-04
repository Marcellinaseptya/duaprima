<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Nota Hauling</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

    <div class="header">
        <h2>CV. Dua Sejahtera Prima</h2>
        <p>Jln. Tembus Mantuil No 11, Kelayan Selatan, Kec. Banjarmasin Selatan</p>
        <h3>Laporan Nota Hauling</h3>
        @if(request('tanggal_mulai') && request('tanggal_selesai'))
            <p>Periode: {{ request('tanggal_mulai') }} s/d {{ request('tanggal_selesai') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sopir</th>
                <th>Tanggal</th>
                <th>Jumlah Rit</th>
                <th>Tarif/Rit</th>
                <th>Bonus</th>
                <th>Total</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notas as $nota)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $nota->sopir->user->nama ?? '-' }}</td>
                    <td>{{ $nota->tanggal }}</td>
                    <td>{{ $nota->jumlah_rit }}</td>
                    <td>Rp{{ number_format($nota->tarif_per_rit, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($nota->bonus, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($nota->total_pemasukan, 0, ',', '.') }}</td>
                    <td class="text-left">{{ $nota->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
