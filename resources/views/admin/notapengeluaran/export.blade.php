<!DOCTYPE html>
<html>
<head>
    <title>Laporan Nota Pengeluaran</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 4px;
        }
        th {
            background-color: #f0f0f0;
        }
        td {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h3>Laporan Nota Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Sopir</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notaPengeluaran as $nota)
            <tr>
                <td>{{ $nota->id }}</td>
                <td>{{ $nota->sopir->user->name }}</td>
                <td>{{ $nota->jenis }}</td>
                <td>{{ $nota->tanggal->format('d-m-Y') }}</td>
                <td>{{ $nota->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
