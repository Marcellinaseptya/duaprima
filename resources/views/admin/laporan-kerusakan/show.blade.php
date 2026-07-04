@extends('layout.main')
@section('title', 'Detail Laporan Kerusakan')

@section('content')
<div class="container mt-4">
    <h3>Detail Laporan Kerusakan</h3>

    <p><strong>Tanggal:</strong> {{ $laporan->tanggal }}</p>
    <p><strong>Sopir:</strong> {{ $laporan->sopir->user->name ?? 'Tidak diketahui' }}</p>
    <p><strong>Truk:</strong> {{ $laporan->mastertruk->plat_nomor ?? 'Tidak diketahui' }}</p>
    <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi_kerusakan }}</p>
    <p><strong>Status:</strong> {{ $laporan->status }}</p>
</div>
@endsection
