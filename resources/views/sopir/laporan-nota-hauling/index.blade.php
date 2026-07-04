@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Laporan Nota Hauling')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Laporan Nota Hauling</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('sopir.laporan-nota-hauling.create') }}" class="btn btn-primary mb-3">
        Tambah Laporan
    </a>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tarif per Rit</th>
                        <th>Jumlah Netto</th>
                        <th>Nota</th>
                        <th>Bukti Transfer</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notas as $laporan)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}</td>
                            <td>Rp{{ number_format($laporan->tarif_per_rit, 0, ',', '.') }}</td>
                            <td>{{ $laporan->jumlah_ritase }}</td>
                            <td>
                                <a href="{{ Storage::url($laporan->file_nota) }}" target="_blank">Lihat Nota</a>
                            </td>
                            <td>
                                <a href="{{ Storage::url($laporan->bukti_transfer) }}" target="_blank">Lihat Bukti</a>
                            </td>
                            <td>{{ $laporan->keterangan ?? '-' }}</td>
                            <td class="text-center">
    @switch($laporan->status)
        @case('MENUNGGU')
            <span class="badge bg-warning text-dark">Menunggu</span>
            @break
        @case('APPROVED')
            <span class="badge bg-success">Approved</span>
            @break
        @case('REJECTED')
            <span class="badge bg-danger">Rejected</span>
            @break
        @default
            <span class="badge bg-secondary">-</span>
    @endswitch
</td>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada laporan nota hauling.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
