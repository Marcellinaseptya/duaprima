<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemasukan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header small { font-size: 12px; }
        .logo { width: 80px; position: absolute; top: -30px; left: 10px; }
        .garis { border-top: 3px solid #000; margin-top: 10px; margin-bottom: 20px; clear: both; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        .text-left { text-align: left; }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; }
        .judul { text-align: center; margin-bottom: 5px; }
        .tanggal-cetak { text-align: left; margin-bottom: 5px; }
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

    {{-- Tanggal Cetak Kiri & Judul Tengah --}}
    <div class="tanggal-cetak">
        <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
    <div class="judul">
        <strong>LAPORAN PEMASUKAN</strong>
    </div>

    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber</th>
                <th>Nominal</th>
                <th class="text-left">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($pemasukans as $pemasukan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($pemasukan->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $pemasukan->sumber }}</td>
                    <td>Rp{{ number_format($pemasukan->nominal, 0, ',', '.') }}</td>
                    <td class="text-left">{{ $pemasukan->keterangan }}</td>
                </tr>
                @php $total += $pemasukan->nominal; @endphp
            @endforeach
            <tr>
                <th colspan="3" style="text-align:right">Total</th>
                <th colspan="2">Rp{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <div class="footer">
        <p>Banjarmasin, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <br><br><br>
        <p><strong>Masriani</strong><br>Owner</p>
    </div>

</body>
</html>