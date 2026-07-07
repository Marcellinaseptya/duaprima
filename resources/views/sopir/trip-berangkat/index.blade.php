@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Trip Berangkat')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between mb-4 align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark"><i class="fas fa-route text-primary mr-2"></i> Daftar Trip Berangkat</h3>
            <p class="text-muted mb-0">Mulai perjalanan baru Anda di sini.</p>
        </div>
        <a href="{{ route('sopir.trip-berangkat.create') }}" class="btn btn-primary shadow-sm font-weight-bold">
            <i class="fas fa-plus-circle mr-2"></i> BUAT PERJALANAN BARU
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

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

                                {{-- Detail --}}
                                <div class="h5 mb-1 font-weight-bold text-gray-800">
                                    {{ $jadwal->lokasi_berangkat ?? 'Dari Pool' }}
                                </div>
                                
                                {{-- Detail Truk --}}
                                <div class="text-sm text-muted mb-3">
                                    <i class="fas fa-truck mr-1"></i> Plat Nomor: 
                                    <span class="font-weight-bold text-dark">{{ $jadwal->mastertruk->plat_nomor ?? '-' }}</span>
                                </div>
                                
                                @if($jadwal->status === 'Siap Berangkat')
                                    <form action="{{ route('sopir.jadwal.mulai', $jadwal->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm w-100 font-weight-bold shadow-sm">
                                            <i class="fas fa-play mr-1"></i> MULAI PERJALANAN
                                        </button>
                                    </form>
                                @endif
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
                <h5 class="text-muted">Anda belum memiliki trip hari ini.</h5>
                <p class="small text-muted">Klik tombol "Buat Perjalanan Baru" di atas untuk memulai trip perdana Anda.</p>
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