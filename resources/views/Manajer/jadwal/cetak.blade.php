<!DOCTYPE html>

<html>
<head>
    <title>Cetak Jadwal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h4 class="mb-4">Laporan Jadwal Operasional</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sopir</th>
                <th>Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwals as $i => $jadwal)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $jadwal->tanggal }}</td>
                <td>{{ $jadwal->sopir->nama ?? '-' }}</td>
                <td>{{ $jadwal->tujuan }}</td>
                <td>{{ $jadwal->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button onclick="window.print()" class="btn btn-dark no-print mt-3">
        <i class="fas fa-print"></i> Cetak
    </button>
</div>

</body>
</html>