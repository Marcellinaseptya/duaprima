@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Detail Nota Hauling')

@section('content')
<div class="container mt-4">
    <h3>Detail Nota Hauling</h3>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $nota->id }}</td>
        </tr>
        <tr>
            <th>Sopir</th>
            <td>{{ $nota->sopir->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $nota->tanggal }}</td>
        </tr>
        <tr>
            <th>Jumlah Ritase</th>
            <td>{{ $nota->jumlah_ritase }}</td>
        </tr>
        <tr>
            <th>Tarif per Rit</th>
            <td>Rp {{ number_format($nota->tarif_per_rit, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pemasukan</th>
            <td>Rp {{ number_format($nota->total_pemasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Bukti Nota</th>
            <td>
                @if($nota->file)
                    <a href="{{ asset('storage/'.$nota->file) }}" target="_blank">Lihat File</a>
                @else
                    Tidak ada file
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('sopir.nota-hauling.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection