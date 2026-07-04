<h3>Laporan Trip Pulang</h3>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pulang</th>
            <th>Truk</th>
            <th>Kondisi</th>
            <th>Sisa Muatan</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trips as $trip)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $trip->waktu_selesai }}</td>
            <td>{{ $trip->tripBerangkat->truk->plat_nomor ?? '-' }}</td>
            <td>{{ $trip->kondisi_truk }}</td>
            <td>{{ number_format($trip->sisa_muatan) }}</td>
            <td>{{ $trip->catatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
