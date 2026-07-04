<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: left; }
        .text-center { text-align: center; }
        .mb-2 { margin-bottom: 10px; }
        .bg-success { background-color: #d4edda; }
        .bg-danger { background-color: #f8d7da; }
        .bg-warning { background-color: #fff3cd; }
    </style>
</head>
<body>

    {{-- Header --}}
    <h2 class="text-center">LAPORAN KEUANGAN</h2>
    <p class="text-center">
        Jln. Tembus Mantuil No 11, Kelayan Selatan, Kec. Banjarmasin Selatan
    </p>

    {{-- Filter Info --}}
    @if(request('start_date') && request('end_date'))
        <p class="mb-2">
            Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }}
            s/d {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
        </p>
    @endif

    {{-- Ringkasan Keuangan --}}
    <table>
        <tr>
            <th>Total Pemasukan</th>
            <td>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pengeluaran</th>
            <td>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Peminjaman Sopir</th>
            <td>Rp {{ number_format($totalPeminjaman, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- Tabel Transaksi --}}
    <h4>Data Transaksi</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Tipe</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $t->keterangan }}</td>
                    <td>{{ ucfirst($t->tipe) }}</td>
                    <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tabel Peminjaman Sopir --}}
    <h4>Peminjaman Sopir (Belum Lunas)</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sopir</th>
                <th>Jumlah Pinjaman</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->sopir->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $p->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pinjaman aktif</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tanggal Cetak --}}
    <p style="text-align: right; margin-top: 30px;">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </p>

</body>
</html>