@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Riwayat Trip Berangkat')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">🚛 Monitoring Trip Berangkat</h1>
            <p class="text-muted small">Memantau data keberangkatan yang diinput oleh Sopir secara real-time.</p>
        </div>
        <a href="{{ route('admin.tripberangkat.export', request()->query()) }}" class="btn btn-success btn-icon-split shadow-sm">
            <span class="icon text-white-50"><i class="fas fa-file-pdf"></i></span>
            <span class="text">Export Laporan</span>
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.tripberangkat.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="small font-weight-bold text-uppercase">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold text-uppercase">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                    <a href="{{ route('admin.tripberangkat.index') }}" class="btn btn-outline-secondary px-4">Reset</a>
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
                            <th class="border-0 small font-weight-bold">TANGGAL</th>
                            <th class="border-0 small font-weight-bold">DETAIL TRIP</th>
                            <th class="border-0 small font-weight-bold">LOKASI</th>
                            <th class="border-0 small font-weight-bold">BIAYA OPERASIONAL</th>
                            <th class="border-0 small font-weight-bold">CATATAN</th>
                            <th class="border-0 small font-weight-bold">DOKUMEN</th>
                            <th class="border-0 small font-weight-bold">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $jadwal)
                            <tr class="text-center">
                                <td>
                                    <span class="text-dark font-weight-bold">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-left">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-gray-200 rounded p-2 mr-2">
                                            <i class="fas fa-id-card text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $jadwal->sopir->user->nama ?? '-' }}</div>
                                            <small class="text-muted">{{ $jadwal->mastertruk->plat_nomor ?? '-' }} | {{ $jadwal->klien->nama_perusahaan ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-light border">{{ $jadwal->lokasi_berangkat ?? '-' }}</span></td>
                                <td class="text-left">
                                    <div class="small">
                                        <div class="d-flex justify-content-between"><span>U. Jalan:</span> <span class="font-weight-bold text-dark">Rp{{ number_format($jadwal->uang_jalan_display,0,',','.') }}</span></div>
                                        <div class="d-flex justify-content-between"><span>U. Makan:</span> <span class="font-weight-bold text-dark">Rp{{ number_format($jadwal->uang_makan_display,0,',','.') }}</span></div>
                                        <div class="d-flex justify-content-between border-top pt-1 mt-1"><span>BBM:</span> <span class="font-weight-bold text-success">Rp{{ number_format($jadwal->harga_bbm_display,0,',','.') }}</span></div>
                                    </div>
                                </td>
                                <td class="small italic text-muted">"{{ Str::limit($jadwal->catatan, 30) ?? '-' }}"</td>
                                <td>
                                    @if($jadwal->nota_perjalanan)
                                        <a href="{{ asset('storage/'.$jadwal->nota_perjalanan) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye mr-1"></i> Nota
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-pill 
                                        @if($jadwal->status == 'Siap Berangkat') badge-warning
                                        @elseif($jadwal->status == 'Berangkat') badge-info
                                        @elseif($jadwal->status == 'Pulang') badge-success
                                        @else badge-secondary @endif px-3">
                                        {{ $jadwal->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-info-circle fa-2x text-light mb-2"></i>
                                    <p class="text-muted">Tidak ada data riwayat trip untuk ditampilkan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($jadwals->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $jadwals->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .table thead th { font-size: 0.65rem; letter-spacing: 0.1em; color: #858796; }
    .table tbody td { font-size: 0.85rem; vertical-align: middle; }
    .italic { font-style: italic; }
    .bg-gray-200 { background-color: #eaecf4; }
</style>
@endsection