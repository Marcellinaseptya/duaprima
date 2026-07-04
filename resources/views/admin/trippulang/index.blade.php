@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Trip Pulang')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">📋 Monitoring Trip Pulang</h1>
        <button onclick="window.print()" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan
        </button>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="small font-weight-bold">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold">Pilih Sopir</label>
                    <select name="sopir_id" class="form-control">
                        <option value="">-- Semua Sopir --</option>
                        @foreach($sopirs as $sopir)
                            <option value="{{ $sopir->id }}" {{ request('sopir_id') == $sopir->id ? 'selected' : '' }}>
                                {{ $sopir->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-filter mr-1"></i> Filter Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @forelse($trips as $trip)
        <div class="card shadow-sm border-0 mb-4 overflow-hidden">
            <div class="card-header bg-dark text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-truck mr-2 text-warning"></i>
                        <strong>{{ $trip->jadwal->mastertruk->plat_nomor ?? '-' }}</strong> 
                        <span class="mx-2">|</span> 
                        <i class="fas fa-user mr-1"></i> {{ $trip->jadwal->sopir->nama ?? '-' }}
                    </span>
                    <span class="badge badge-light">
                        {{ \Carbon\Carbon::parse($trip->waktu_selesai)->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="row text-center mb-3">
                    <div class="col-md-3 border-right">
                        <label class="text-xs text-uppercase text-muted font-weight-bold">Muatan</label>
                        <p class="h6 font-weight-bold">{{ number_format($trip->muatan_netto) }} kg</p>
                    </div>
                    <div class="col-md-3 border-right">
                        <label class="text-xs text-uppercase text-muted font-weight-bold">Ritase</label>
                        <p class="h6 font-weight-bold">{{ $trip->ritase }} Rit</p>
                    </div>
                    <div class="col-md-3 border-right">
                        <label class="text-xs text-uppercase text-muted font-weight-bold">BBM</label>
                        <p class="h6 font-weight-bold text-danger">Rp{{ number_format($trip->biaya_bbm) }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-xs text-uppercase text-muted font-weight-bold">Bonus</label>
                        <p class="h6 font-weight-bold text-success">Rp{{ number_format($trip->bonus) }}</p>
                    </div>
                </div>

                <div class="row mt-4 p-3 bg-light rounded mx-1">
                    <div class="col-md-6 border-right">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small font-weight-bold text-primary">GAJI SOPIR (25%)</span>
                            <span class="h5 font-weight-bold text-primary mb-0">Rp{{ number_format($trip->total_gaji_sopir) }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center pl-3">
                            <span class="small font-weight-bold text-dark">UNTUNG CV (75%)</span>
                            <span class="h5 font-weight-bold text-dark mb-0">Rp{{ number_format($trip->total_cv) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        <i class="fas fa-sticky-note mr-1"></i> Catatan: {{ $trip->catatan ?? 'Tidak ada catatan' }}
                    </div>
                    @if($trip->nota_bbm)
                        <a href="{{ asset('uploads/nota_bbm/'.$trip->nota_bbm) }}" target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-image mr-1"></i> Lihat Nota BBM
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 shadow-sm bg-white rounded">
            <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
            <p class="text-muted">Tidak ditemukan data trip untuk filter tersebut.</p>
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $trips->links() }}
    </div>
</div>

<style>
    .card { transition: 0.3s; }
    .bg-light { background-color: #f8f9fc !important; }
    .text-xs { font-size: .7rem; }
    @media print {
        .sidebar, .btn, .card-header, .filter-card { display: none !important; }
    }
</style>
@endsection
