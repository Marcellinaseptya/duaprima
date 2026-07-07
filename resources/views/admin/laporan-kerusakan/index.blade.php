@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Laporan Kerusakan Truk')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">🛠️ Laporan Kerusakan Truk</h1>
            <p class="text-muted small">Kelola dan pantau kondisi teknis armada secara berkala.</p>
        </div>
        <a href="{{ route('admin.laporankerusakan.export', request()->all()) }}" class="btn btn-success btn-icon-split shadow-sm" target="_blank">
            <span class="icon text-white-50"><i class="fas fa-file-pdf"></i></span>
            <span class="text">Export PDF</span>
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporankerusakan.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="small font-weight-bold text-uppercase">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold text-uppercase">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.laporankerusakan.index') }}" class="btn btn-outline-secondary px-4">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th class="border-0 small font-weight-bold">NO</th>
                            <th class="border-0 small font-weight-bold">TANGGAL</th>
                            <th class="border-0 small font-weight-bold">DETAIL ARMADA</th>
                            <th class="border-0 small font-weight-bold">DESKRIPSI KERUSAKAN</th>
                            <th class="border-0 small font-weight-bold">FOTO UNIT</th>
                            <th class="border-0 small font-weight-bold">STATUS</th>
                            <th class="border-0 small font-weight-bold">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $index => $laporan)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="text-dark font-weight-bold">{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d/m/Y') }}</span>
                            </td>
                            <td class="text-left">
                                <div class="d-flex align-items-center">
                                    <div class="bg-gray-200 rounded p-2 mr-2 text-primary">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $laporan->truk->plat_nomor ?? '-' }}</div>
                                        <small class="text-muted">Sopir: {{ $laporan->sopir->nama ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left">
                                <div class="small text-dark" style="max-width: 200px;">
                                    {{ Str::limit($laporan->deskripsi, 50) }}
                                </div>
                            </td>
                            <td>
                                @if($laporan->foto && file_exists(public_path($laporan->foto)))
                                    <a href="{{ asset($laporan->foto) }}" target="_blank">
                                        <img src="{{ asset($laporan->foto) }}" class="rounded shadow-sm border" width="80" height="60" style="object-fit: cover;">
                                    </a>
                                @else
                                    <span class="badge badge-light border text-muted small">No Image</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'DISETUJUI' => 'success',
                                        'PENDING' => 'warning',
                                        'MENUNGGU' => 'warning',
                                        'DITOLAK' => 'danger'
                                    ][strtoupper($laporan->status)] ?? 'secondary';
                                @endphp
                                <span class="badge badge-{{ $statusClass }} px-3 py-2">
                                    <i class="fas fa-circle mr-1 small"></i> {{ $laporan->status }}
                                </span>
                            </td>
                            <td class="small italic text-muted">
                                {{ $laporan->alasan_penolakan ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-tools fa-3x text-light mb-3"></i>
                                <p class="text-muted">Belum ada laporan kerusakan yang tercatat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th { font-size: 0.7rem; letter-spacing: 0.05em; color: #858796; text-transform: uppercase; }
    .table tbody td { font-size: 0.85rem; vertical-align: middle; }
    .bg-gray-200 { background-color: #f8f9fc; }
    .italic { font-style: italic; }
</style>
@endsection