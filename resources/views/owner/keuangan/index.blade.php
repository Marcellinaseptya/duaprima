@extends('layout.main')
@include('partials.sidebar-owner')
@section('title', 'Laporan Keuangan')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Laporan Keuangan</h1>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('owner.keuangan.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="small font-weight-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $start_date }}">
                </div>
                <div class="col-md-4">
                    <label class="small font-weight-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $end_date }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-filter mr-1"></i> Filter Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ringkasan Keuangan ({{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }})</h6>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between border-0 border-bottom">
                    <span class="text-success"><i class="fas fa-arrow-down mr-2"></i>Total Pemasukan (Faktur Lunas)</span>
                    <strong class="text-success">Rp{{ number_format($totalPemasukan) }}</strong>
                </li>
                
                <li class="list-group-item border-0 pt-4 pb-2">
                    <strong>Rincian Pengeluaran Terverifikasi:</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between border-0">
                    <span class="text-muted ml-3"><i class="fas fa-gas-pump mr-2"></i>Total BBM (Trip & Manual)</span>
                    <span class="text-muted">Rp{{ number_format($totalBbm) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between border-0">
                    <span class="text-muted ml-3"><i class="fas fa-tools mr-2"></i>Total Perbaikan Truk</span>
                    <span class="text-muted">Rp{{ number_format($totalPerbaikan) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between border-0">
                    <span class="text-muted ml-3"><i class="fas fa-utensils mr-2"></i>Total Biaya Lapangan (Uang Jalan & Makan)</span>
                    <span class="text-muted">Rp{{ number_format($totalTripBiaya) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between border-0">
                    <span class="text-muted ml-3"><i class="fas fa-hand-holding-usd mr-2"></i>Total Pinjaman Sopir</span>
                    <span class="text-muted">Rp{{ number_format($totalPinjaman) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between border-0 border-bottom">
                    <span class="text-danger font-weight-bold"><i class="fas fa-arrow-up mr-2"></i>Total Pengeluaran</span>
                    <strong class="text-danger">Rp{{ number_format($totalPengeluaran) }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between border-0 bg-light mt-3 py-3 rounded">
                    <span class="h5 font-weight-bold mb-0 text-dark">Saldo Akhir / Laba Bersih</span>
                    <span class="h5 font-weight-bold mb-0 {{ $labaBersih >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp{{ number_format($labaBersih) }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
