<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ritase</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Laporan Ritase</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sopir</th>
                <th>Truk</th>
                <th>Tujuan</th>
                <th>Netto</th>
                <th>Tarif</th>
                <th>BBM</th>
                <th>Gaji Sopir</th>
                <th>Untung CV</th>
                <th>Bonus</th>
                <th>Harga Terbaru</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ritases as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                <td>{{ $item->tripBerangkat->sopir->nama ?? '-' }}</td>
                <td>{{ $item->tripBerangkat->truk->nama ?? '-' }}</td>
                <td>{{ $item->tripBerangkat->tujuan }}</td>
                <td>{{ number_format($item->muatan_netto) }} kg</td>
                <td>Rp{{ number_format($item->tarif) }}</td>
                <td>Rp{{ number_format($item->biaya_bbm) }}</td>
                <td>Rp{{ number_format($item->gaji_sopir) }}</td>
                <td>Rp{{ number_format($item->keuntungan_cv) }}</td>
                <td>Rp{{ number_format($item->bonus) }}</td>
                <td>{{ $item->harga_terbaru ? 'Rp'.number_format($item->harga_terbaru) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
