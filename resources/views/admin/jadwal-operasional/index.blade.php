@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Jadwal Operasional')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">🗓️ Jadwal Operasional</h1>
            <p class="text-muted small mb-0">Data jadwal yang telah disusun oleh Manajer untuk operasional armada.</p>
        </div>
        <a href="{{ route('admin.jadwal-operasional.export', request()->all()) }}" class="btn btn-danger btn-sm shadow-sm px-3">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
        </a>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-light rounded">
            <form method="GET" action="{{ route('admin.jadwal-operasional.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="small font-weight-bold text-dark">DARI TANGGAL</label>
                    <input type="date" name="tanggal_awal" class="form-control form-control-sm border-0 shadow-sm" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-4">
                    <label class="small font-weight-bold text-dark">SAMPAI TANGGAL</label>
                    <input type="date" name="tanggal_akhir" class="form-control form-control-sm border-0 shadow-sm" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-sm btn-primary px-4 shadow-sm">
                        <i class="fas fa-filter mr-1"></i> Filter Jadwal
                    </button>
                    <a href="{{ route('admin.jadwal-operasional.index') }}" class="btn btn-sm btn-white border px-3">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white shadow-sm">
                        <tr class="text-center">
                            <th class="py-3 border-0" width="5%">NO</th>
                            <th class="border-0">TANGGAL</th>
                            <th class="border-0">SOPIR & ARMADA</th>
                            <th class="border-0">TUJUAN / KLIEN</th>
                            <th class="border-0">ESTIMASI JAM</th>
                            <th class="border-0">CATATAN MANAJER</th>
                            <th class="border-0">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwals as $jadwal)
                            <tr class="text-center">
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td class="text-left py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-gray-200 p-2 mr-2 text-primary">
                                            <i class="fas fa-user-tag small"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark text-uppercase">{{ $jadwal->sopir->nama ?? '-' }}</div>
                                            <div class="text-xs text-muted font-italic">{{ $jadwal->mastertruk->plat_nomor ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-left">
                                    <div class="text-dark font-weight-bold">{{ $jadwal->tujuan }}</div>
                                    <div class="text-xs text-primary">{{ $jadwal->klien->nama_perusahaan ?? 'Klien Umum' }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light border px-2 py-1 font-weight-normal">
                                        <i class="far fa-clock text-success mr-1"></i> {{ $jadwal->jam_berangkat }} 
                                        <span class="mx-1">→</span> 
                                        <i class="far fa-clock text-danger mr-1"></i> {{ $jadwal->jam_kembali ?? '--:--' }}
                                    </div>
                                </td>
                                <td class="small text-muted" style="max-width: 200px;">
                                    {{ $jadwal->catatan ?? '-' }}
                                </td>
                                <td>
                                    {{-- Status otomatis dari database --}}
                                    @php
                                        $badgeColor = 'badge-secondary';
                                        if($jadwal->status == 'Siap Berangkat') $badgeColor = 'badge-warning';
                                        if($jadwal->status == 'Berangkat') $badgeColor = 'badge-info';
                                        if($jadwal->status == 'Selesai') $badgeColor = 'badge-success';
                                    @endphp
                                    <span class="badge badge-pill {{ $badgeColor }} px-3 shadow-sm">
                                        {{ $jadwal->status ?? 'Rencana' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center text-muted border-0">
                                    <i class="fas fa-calendar-times fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada jadwal operasional yang dibuat oleh Manajer.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($jadwals->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $jadwals->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .table thead th { font-size: 0.7rem; letter-spacing: 1px; }
    .table tbody td { font-size: 0.85rem; border-bottom: 1px solid #f8f9fc; }
    .bg-gray-200 { background-color: #eaecf4; }
    .badge-pill { font-weight: 500; font-size: 0.75rem; }
    
    @media print {
        .sidebar, .btn, form, .no-print { display: none !important; }
        .card { border: none !important; }
    }
</style>
@endsection