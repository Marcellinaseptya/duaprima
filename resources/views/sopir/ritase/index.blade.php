@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Ritase Saya')

@section('content')
<div class="container mt-4">
    <h4>Data Ritase</h4>
    <a href="{{ route('sopir.ritase.create') }}" class="btn btn-primary mb-3">+ Tambah Ritase</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Rit</th>
                <th>Tarif</th>
                <th>Bonus</th>
                <th>Gaji</th>
                <th>Keuntungan CV</th>
                <th>Bukti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ritases as $item)
                <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jumlah_rit }}</td>
                    <td>Rp{{ number_format($item->tarif_per_rit) }}</td>
                    <td>Rp{{ number_format($item->bonus ?? 0) }}</td>
                    <td>Rp{{ number_format($item->total_gaji) }}</td>
                    <td>Rp{{ number_format($item->total_cv) }}</td>
                    <td>
                        @if($item->bukti_transfer)
                            <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank">Lihat</a>
                        @else
                            Tidak ada
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
