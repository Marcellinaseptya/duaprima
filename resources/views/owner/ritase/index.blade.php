@extends('layout.main')
@include('partials.sidebar-owner')

@section('title', 'Laporan Ritase')

@section('content')
<div class="container mt-4">
    <h3>Laporan Ritase Sopir</h3>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Sopir</th>
                        <th>Truk</th>
                        <th>Tujuan</th>
                        <th>Netto</th>
                        <th>Tarif</th>
                        <th>Total</th>
                        <th>Bonus</th>
                        <th>Gaji Sopir</th>
                        <th>Keuntungan CV</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ritases as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->sopir->user->name ?? '-' }}</td>
                            <td>{{ $item->jadwal->truk->plat_nomor ?? '-' }}</td>
                            <td>{{ $item->jadwal->klien->nama ?? '-' }}</td>
                            <td>{{ number_format($item->netto) }} kg</td>
                            <td>Rp{{ number_format($item->tarif) }}</td>
                            <td>Rp{{ number_format($item->total) }}</td>
                            <td>Rp{{ number_format($item->bonus) }}</td>
                            <td>Rp{{ number_format($item->gaji_sopir) }}</td>
                            <td>Rp{{ number_format($item->keuntungan_cv) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">Belum ada data ritase.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
