@extends('layout.main')
@include('partials.sidebar-sopir')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Laporan Kerusakan Saya</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Tombol tambah --}}
        <a href="{{ route('sopir.laporan-kerusakan.create') }}" class="btn btn-primary mb-3">
            + Buat Laporan Baru
        </a>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Daftar Laporan Kerusakan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover m-0">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Plat Nomor</th>
                                <th>Tanggal Laporan</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporans as $laporan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $laporan->mastertruk->plat_nomor ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d-m-Y') }}</td>
                                    <td>{{ $laporan->deskripsi_kerusakan }}</td>
                                    <td class="text-center">
                                        @if($laporan->foto)
                                            <a href="{{ asset('storage/' . $laporan->foto) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @switch(strtolower($laporan->status))
                                            @case('menunggu')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                                @break
                                            @case('disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                                @break
                                            @case('ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">-</span>
                                        @endswitch
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada laporan kerusakan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
