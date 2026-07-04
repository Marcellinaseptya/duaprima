@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="container-fluid py-4" style="background: #f8fafd; min-height: 100vh;">
    {{-- Header Section dengan Glassmorphism Effect --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 p-3" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border-radius: 15px; border: 1px solid rgba(255,255,255,0.5);">
        <div>
            <h1 class="h3 mb-1 text-dark font-weight-bold" style="letter-spacing: -0.5px;">📑 Rekap Laporan Kerusakan</h1>
            <p class="text-muted small mb-0"><i class="fas fa-info-circle mr-1"></i> Dashboard pengelolaan aset dan perbaikan unit truk.</p>
        </div>
        <div class="no-print">
            <a href="{{ route('admin.laporankerusakan.export', request()->only(['tanggal_mulai', 'tanggal_selesai'])) }}" 
               class="btn btn-danger shadow-sm border-0" style="border-radius: 10px; padding: 10px 20px; transition: 0.3s;">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </a>
        </div>
    </div>

    {{-- Modern Filter Box --}}
    <div class="card shadow-sm mb-4 border-0" style="border-radius: 20px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.laporankerusakan.index') }}" class="row align-items-end g-3">
                <div class="col-md-4">
                    <label class="small text-uppercase font-weight-bold text-secondary mb-2">Periode Awal</label>
                    <input type="date" name="tanggal_mulai" class="form-control custom-input" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-4">
                    <label class="small text-uppercase font-weight-bold text-secondary mb-2">Periode Akhir</label>
                    <input type="date" name="tanggal_selesai" class="form-control custom-input" value="{{ request('tanggal_selesai') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm mr-2" style="border-radius: 10px; height: 45px;">
                        <i class="fas fa-filter mr-2"></i> Filter Data
                    </button>
                    <a href="{{ route('admin.laporankerusakan.index') }}" class="btn btn-light px-4 border" style="border-radius: 10px; height: 45px; line-height: 30px;">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Modern Table Card --}}
    <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-table">
                <thead>
                    <tr>
                        <th class="border-0 px-4 py-3">NO</th>
                        <th class="border-0">DETAIL WAKTU</th>
                        <th class="border-0">SOPIR & UNIT</th>
                        <th class="border-0">DESKRIPSI KERUSAKAN</th>
                        <th class="border-0 text-center">STATUS</th>
                        <th class="border-0 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $lapor)
                    <tr>
                        <td class="text-center font-weight-bold text-muted px-4">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="icon-date mr-2"><i class="far fa-calendar-alt"></i></div>
                                <div>
                                    <span class="d-block font-weight-bold">{{ \Carbon\Carbon::parse($lapor->tanggal)->format('d M Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($lapor->tanggal)->format('H:i') }} WIB</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-bold text-dark mb-1">{{ $lapor->sopir->nama ?? $lapor->sopir->user->name ?? '-' }}</div>
                            <span class="badge bg-soft-primary text-primary px-2 py-1"><i class="fas fa-truck mr-1"></i> {{ $lapor->truk->plat_nomor ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <p class="mb-0 text-secondary small" style="line-height: 1.4; max-width: 280px;">
                                {{ Str::limit($lapor->deskripsi, 85) }}
                            </p>
                        </td>
                        <td class="text-center">
                            @php
                                $status = [
                                    'DISETUJUI' => ['bg' => '#e6fffa', 'color' => '#047857', 'icon' => 'fa-check-circle'],
                                    'DITOLAK'   => ['bg' => '#fff5f5', 'color' => '#c53030', 'icon' => 'fa-times-circle'],
                                    'PENDING'  => ['bg' => '#fffaf0', 'color' => '#b45309', 'icon' => 'fa-clock']
                                ][$lapor->status] ?? ['bg' => '#f3f4f6', 'color' => '#374151', 'icon' => 'fa-info-circle'];
                            @endphp
                            <div class="status-pill" style="background: {{ $status['bg'] }}; color: {{ $status['color'] }};">
                                <i class="fas {{ $status['icon'] }} mr-1"></i> {{ $lapor->status }}
                            </div>
                        </td>
                        <td class="text-center">
                            @if($lapor->file_bukti)
                                <a href="{{ asset('storage/' . $lapor->file_bukti) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-external-link-alt mr-1"></i> Bukti
                                </a>
                            @else
                                <span class="text-muted small italic">No File</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                                <h5 class="text-secondary">Tidak ada laporan ditemukan</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Custom Styling for Modern UI */
    .custom-input {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        height: 45px;
        transition: 0.3s;
    }
    .custom-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
    }

    .custom-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .custom-table tbody tr {
        transition: 0.2s;
    }
    .custom-table tbody tr:hover {
        background-color: #fcfdfe;
        transform: scale(1.002);
    }

    .bg-soft-primary { background: #eef2ff; }
    
    .status-pill {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .icon-date {
        width: 35px;
        height: 35px;
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4e73df;
    }

    .btn-view {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #4a5568;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none !important;
        transition: 0.2s;
    }
    .btn-view:hover {
        background: #4e73df;
        color: #fff;
        border-color: #4e73df;
    }
</style>
@endsection