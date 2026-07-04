@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Trip Berangkat')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="mb-4">
        <h3 class="font-weight-bold text-dark"><i class="fas fa-route text-primary mr-2"></i> Daftar Trip Siap Berangkat</h3>
        <p class="text-muted">Pilih jadwal di bawah ini untuk memulai pengiriman Anda hari ini.</p>
    </div>

    <div class="row">
        @forelse($jadwals as $jadwal)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 ripple-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                {{-- Tanggal & Badge --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                    <span class="badge badge-pill badge-warning px-3">{{ $jadwal->status }}</span>
                                </div>

                                {{-- Detail Klien --}}
                                <div class="h5 mb-1 font-weight-bold text-gray-800">
                                    {{ $jadwal->klien->nama_perusahaan ?? 'Klien Umum' }}
                                </div>
                                
                                {{-- Detail Truk --}}
                                <div class="text-sm text-muted mb-3">
                                    <i class="fas fa-truck mr-1"></i> Plat Nomor: 
                                    <span class="font-weight-bold text-dark">{{ $jadwal->mastertruk->plat_nomor ?? '-' }}</span>
                                </div>

                                {{-- Tombol Aksi --}}
                                <a href="{{ route('sopir.trip-berangkat.create', $jadwal->id) }}" 
                                   class="btn btn-success btn-block shadow-sm font-weight-bold">
                                    <i class="fas fa-play-circle mr-2"></i> MULAI PERJALANAN
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-box-open fa-4x text-light"></i>
                </div>
                <h5 class="text-muted">Tidak ada jadwal perjalanan untuk saat ini.</h5>
                <p class="small text-muted">Silakan hubungi Admin atau Manajer untuk pembagian jadwal.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Card Styling */
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .ripple-card {
        transition: transform 0.2s ease-in-out;
        border: none;
        border-radius: 12px;
    }
    .ripple-card:hover {
        transform: translateY(-5px);
    }
    .btn-success {
        background-color: #1cc88a;
        border: none;
        border-radius: 8px;
        padding: 10px;
    }
    .btn-success:hover {
        background-color: #17a673;
    }
    /* Mobile optimization */
    @media (max-width: 576px) {
        .h5 { font-size: 1.1rem; }
    }
</style>
@endsection