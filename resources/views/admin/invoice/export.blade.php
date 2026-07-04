<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Ritase</title>
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
        <h3>Invoice Ritase</h3>
        @if(request('from') && request('to'))
            <p>Periode: {{ request('from') }} s/d {{ request('to') }}</p>
        @endif
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sopir</th>
                <th>Tujuan</th>
                <th>Muatan Netto</th>
                <th>Tarif</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($ritases as $ritase)
                @php
                    $sub = $ritase->muatan_netto * $ritase->tarif;
                    $total += $sub;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ritase->created_at->format('d-m-Y') }}</td>
                    <td>{{ $ritase->tripBerangkat->sopir->user->nama ?? '-' }}</td>
                    <td>{{ $ritase->tripBerangkat->tujuan ?? '-' }}</td>
                    <td>{{ number_format($ritase->muatan_netto) }} kg</td>
                    <td>Rp{{ number_format($ritase->tarif) }}</td>
                    <td>Rp{{ number_format($sub) }}</td>
                </tr>
            @endforeach
            <tr class="font-weight-bold">
                <td colspan="6" class="text-right">TOTAL TAGIHAN</td>
                <td>Rp{{ number_format($total) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>