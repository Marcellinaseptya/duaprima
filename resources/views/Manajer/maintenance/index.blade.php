@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Maintenance')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Monitoring Maintenance</h1>
            <p class="text-muted small mb-0">Laporan riwayat perbaikan armada truk dari Manajer.</p>
        </div>
        {{-- Tombol Cetak --}}
        <a href="{{ route('manajer.maintenance.print') }}" target="_blank" class="btn btn-danger btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-file-pdf"></i>
            </span>
            <span class="text">Cetak Laporan</span>
        </a>
    </div>

    {{-- Statistik Ringkas (Optional) --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $maintenances->count() }} Record</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i>Daftar Perbaikan Truk
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center text-secondary border-0" width="5%">NO</th>
                            <th class="border-0">UNIT TRUK</th>
                            <th class="border-0">TANGGAL PERBAIKAN</th>
                            <th class="border-0">DESKRIPSI KELUHAN</th>
                            <th class="border-0">BIAYA OPERASIONAL</th>
                            <th class="text-center border-0">VERIFIKASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $item)
                            <tr>
                                <td class="text-center text-muted font-weight-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle p-2 mr-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-truck-moving fa-sm"></i>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold text-dark d-block">{{ $item->mastertruk->plat_nomor ?? '-' }}</span>
                                            <small class="text-muted">ID Unit: #{{ $item->mastertruk->id ?? '0' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark">
                                        <i class="far fa-calendar-alt text-primary mr-2"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small italic">"{{ Str::limit($item->deskripsi_perbaikan, 60) }}"</span>
                                </td>
                                <td>
                                    <span class="font-weight-bold text-dark">
                                        Rp{{ number_format($item->biaya_servis, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-pill badge-light text-success border border-success px-3">
                                        <i class="fas fa-check-circle mr-1"></i> Terarsip
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/gray/data-report.svg" alt="Empty" style="width: 150px;" class="mb-3">
                                    <p class="text-muted">Tidak ada data maintenance yang dapat ditampilkan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Footer Card untuk Pagination jika perlu --}}
        <div class="card-footer bg-white border-0 py-3">
            <small class="text-muted italic">*Data ini bersifat read-only (dikelola oleh Manajer).</small>
        </div>
    </div>
</div>

<style>
    /* Styling Tambahan */
    .table thead th {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        padding: 15px;
    }
    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .card { border-radius: 0.5rem; }
    .badge-pill { font-weight: 600; font-size: 0.75rem; }
    .bg-light { background-color: #f8f9fc !important; }
    .italic { font-style: italic; }
</style>
@endsection