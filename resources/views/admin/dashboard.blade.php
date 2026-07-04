@extends('layout.main')
@include('partials.sidebar-admin')
@section('title', 'Dashboard Admin')

@section('content')
<style>
    /* Custom Styling untuk mempercantik */
    .card-stats {
        transition: transform 0.3s ease;
        border: none !important;
    }
    .card-stats:hover {
        transform: translateY(-5px);
    }
    .icon-shape {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .bg-gradient-success { background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important; }
    .bg-gradient-danger { background: linear-gradient(87deg, #f5365c 0, #f56036 100%) !important; }
    .bg-gradient-primary { background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important; }
    .bg-gradient-info { background: linear-gradient(87deg, #11cdef 0, #1171ef 100%) !important; }
    .bg-gradient-warning { background: linear-gradient(87deg, #fb6340 0, #fbb140 100%) !important; }
    
    .table thead th {
        background-color: #f8f9fe;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border-bottom: 1px solid #e9ecef;
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Ringkasan Operasional</h1>
        <span class="badge badge-light shadow-sm p-2">
            <i class="far fa-calendar-alt"></i> {{ date('d M Y') }}
        </span>
    </div>

    {{-- Ringkasan Cards --}}
    <div class="row">
        @php
            $stats = [
                ['label'=>'Total Pemasukan','value'=>'Rp '.number_format($totalPemasukan),'bg'=>'success','icon'=>'fa-arrow-up', 'grad' => 'bg-gradient-success'],
                ['label'=>'Total Pengeluaran','value'=>'Rp '.number_format($totalPengeluaran),'bg'=>'danger','icon'=>'fa-arrow-down', 'grad' => 'bg-gradient-danger'],
                ['label'=>'Truk Aktif','value'=>$totalTrukAktif,'bg'=>'primary','icon'=>'fa-truck', 'grad' => 'bg-gradient-primary'],
                ['label'=>'Sopir Aktif','value'=>$totalSopirAktif,'bg'=>'info','icon'=>'fa-id-card', 'grad' => 'bg-gradient-info'],
                ['label'=>'Laporan Kerusakan','value'=>$totalLaporan,'bg'=>'warning','icon'=>'fa-wrench', 'grad' => 'bg-gradient-warning'],
            ];
        @endphp

        @foreach($stats as $item)
        <div class="col-xl-3 col-md-6 mb-4"> {{-- Diubah ke col-3 supaya lebih compact --}}
            <div class="card card-stats shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $item['bg'] }} text-uppercase mb-1">
                                {{ $item['label'] }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item['value'] }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape {{ $item['grad'] }} text-white shadow">
                                <i class="fas {{ $item['icon'] }} fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Laporan Terbaru --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold text-gray-800">
                        <i class="fas fa-list text-primary mr-2"></i> Laporan Kerusakan Terbaru
                    </h5>
                    <a href="#" class="btn btn-sm btn-primary shadow-sm">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Sopir</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanTerbaru as $laporan)
                            <tr>
                                <td class="font-weight-bold">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-2 bg-light rounded-circle text-center" style="width: 30px; height: 30px; line-height: 30px;">
                                            <i class="fas fa-user-circle text-muted"></i>
                                        </div>
                                        {{ $laporan->sopir->nama ?? '-' }}
                                    </div>
                                </td>
                                <td class="text-wrap" style="max-width: 250px;">{{ Str::limit($laporan->deskripsi, 50) }}</td>
                                <td class="text-center">
                                    @php
                                        $statusClass = [
                                            'approved' => 'badge-success',
                                            'pending' => 'badge-warning',
                                            'rejected' => 'badge-danger'
                                        ][$laporan->status] ?? 'badge-secondary';
                                    @endphp
                                    <span class="badge badge-pill {{ $statusClass }} px-3 py-2">
                                        {{ strtoupper($laporan->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                                    <p>Belum ada laporan masuk saat ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection