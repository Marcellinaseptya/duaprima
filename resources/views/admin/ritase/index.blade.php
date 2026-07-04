@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Ritase Lengkap')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">📋 Data Ritase Lengkap</h1>
            <p class="text-muted small mb-0">Manajemen pendapatan armada dan pembagian hasil (Sopir 25% : CV 75%).</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-sm btn-outline-dark shadow-sm px-3">
                <i class="fas fa-print fa-sm mr-1"></i> Cetak Laporan
            </button>
            <a href="#" class="btn btn-sm btn-success shadow-sm px-3">
                <i class="fas fa-file-excel fa-sm mr-1"></i> Export Excel
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 mb-4 no-print">
        <div class="card-body bg-light rounded">
            <form method="GET" action="{{ route('admin.ritase.index') }}" class="row g-2 align-items-end text-xs">
                <div class="col-md-3">
                    <label class="font-weight-bold text-secondary mb-1">PERIODE AWAL</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm border-0 shadow-sm">
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold text-secondary mb-1">PERIODE AKHIR</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm border-0 shadow-sm">
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold text-secondary mb-1">SOPIR</label>
                    <select name="sopir_id" class="form-control form-control-sm border-0 shadow-sm">
                        <option value="">-- Semua Sopir --</option>
                        @foreach ($sopirs as $sopir)
                            <option value="{{ $sopir->id }}" {{ request('sopir_id') == $sopir->id ? 'selected' : '' }}>
                                {{ $sopir->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary flex-grow-1 shadow-sm">
                        <i class="fas fa-search mr-1"></i> Cari
                    </button>
                    <a href="{{ route('admin.ritase.index') }}" class="btn btn-sm btn-white border flex-grow-1 shadow-sm">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                    <thead class="bg-dark text-white text-center">
                        <tr class="text-nowrap">
                            <th class="py-3 px-2 border-0" width="1%">#</th>
                            <th class="border-0">TANGGAL</th>
                            <th class="border-0 text-left">SOPIR / TRUK</th>
                            <th class="border-0">MUATAN</th>
                            <th class="border-0">RIT</th>
                            <th class="border-0">TARIF</th>
                            <th class="border-0 bg-danger-soft text-danger">BBM</th>
                            <th class="border-0">U.MAKAN</th>
                            <th class="border-0">U.JALAN</th>
                            <th class="border-0 text-success">BONUS</th>
                            <th class="border-0 bg-info text-white">TOTAL BERSIH</th>
                            <th class="border-0 bg-primary text-white">GAJI (25%)</th>
                            <th class="border-0 bg-dark-light text-white">CV (75%)</th>
                            <th class="border-0">NOTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $grand_total_bersih = 0;
                            $grand_gaji_sopir = 0;
                            $grand_untung_cv = 0;
                        @endphp
                        @forelse ($trips as $trip)
                            @php
                                $muatan = $trip->muatan_netto;
                                $rit = $trip->ritase;
                                $tarif = $trip->tarif_per_rit;
                                $bbm = $trip->biaya_bbm ?? 0;
                                $uang_makan = $trip->uang_makan ?? 0;
                                $uang_jalan = $trip->uang_jalan ?? 0;
                                $bonus = $muatan > 11500 ? 60000 : 0;
                                
                                $total_bersih = ($rit * $tarif + $bonus + $uang_makan + $uang_jalan) - $bbm;
                                $gaji_sopir = $total_bersih * 0.25;
                                $untung_cv = $total_bersih * 0.75;

                                $grand_total_bersih += $total_bersih;
                                $grand_gaji_sopir += $gaji_sopir;
                                $grand_untung_cv += $untung_cv;
                            @endphp
                            <tr class="text-center text-nowrap">
                                <td class="text-muted small">{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($trip->waktu_selesai)->format('d/m/y') }}</td>
                                <td class="text-left">
                                    <div class="font-weight-bold text-dark text-uppercase">{{ $trip->jadwal->sopir->nama ?? '-' }}</div>
                                    <div class="text-xs text-muted"><i class="fas fa-truck-moving mr-1"></i>{{ $trip->jadwal->mastertruk->plat_nomor ?? '-' }}</div>
                                </td>
                                <td><span class="badge badge-light border text-dark px-2 font-weight-normal">{{ number_format($muatan) }} kg</span></td>
                                <td>{{ $rit }}</td>
                                <td>{{ number_format($tarif/1000) }}k</td>
                                <td class="text-danger font-weight-bold">{{ number_format($bbm/1000) }}k</td>
                                <td>{{ number_format($uang_makan/1000) }}k</td>
                                <td>{{ number_format($uang_jalan/1000) }}k</td>
                                <td class="text-success font-weight-bold">+{{ number_format($bonus/1000) }}k</td>
                                <td class="font-weight-bold text-info border-left border-right bg-info-light">Rp{{ number_format($total_bersih) }}</td>
                                <td class="font-weight-bold text-primary bg-primary-light">Rp{{ number_format($gaji_sopir) }}</td>
                                <td class="font-weight-bold text-dark bg-gray-100">Rp{{ number_format($untung_cv) }}</td>
                                <td>
                                    @if($trip->nota_bbm)
                                        <a href="{{ asset('uploads/nota_bbm/'.$trip->nota_bbm) }}" target="_blank" class="btn btn-xs btn-info shadow-sm p-1 rounded-circle" title="Lihat Nota">
                                            <i class="fas fa-camera fa-xs text-white px-1"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="py-5 text-center text-muted border-0">
                                    <img src="https://illustrations.popsy.co/gray/data-report.svg" style="width: 120px;" class="mb-3 opacity-50">
                                    <p class="mb-0">Tidak ditemukan data ritase untuk periode ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    {{-- Baris Total Keseluruhan --}}
                    @if($trips->count() > 0)
                    <tfoot class="bg-light font-weight-bold">
                        <tr class="text-center text-nowrap">
                            <td colspan="10" class="text-right py-3">TOTAL REKAPITULASI:</td>
                            <td class="text-info">Rp{{ number_format($grand_total_bersih) }}</td>
                            <td class="text-primary">Rp{{ number_format($grand_gaji_sopir) }}</td>
                            <td class="text-dark border-right">Rp{{ number_format($grand_untung_cv) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-4 d-flex justify-content-between align-items-center no-print">
        <p class="text-muted small">Menampilkan {{ $trips->count() }} data dari total {{ $trips->total() }} record.</p>
        {{ $trips->links() }}
    </div>
</div>

<style>
    /* Table Styling */
    .table thead th { vertical-align: middle; border: none; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .table td { border-top: 1px solid #f8f9fc; }
    
    /* Background colors for groups */
    .bg-danger-soft { background-color: #fff5f5; }
    .bg-info-light { background-color: #f0faff; }
    .bg-primary-light { background-color: #f0f4ff; }
    .bg-dark-light { background-color: #4e4e4e; }
    .bg-gray-100 { background-color: #f8f9fc; }

    /* Print styling */
    @media print {
        .no-print { display: none !important; }
        .card { border: none !important; shadow: none !important; }
        body { background: white !important; }
        .table { width: 100% !important; font-size: 9px !important; }
        @page { size: landscape; margin: 1cm; }
    }
</style>
@endsection
