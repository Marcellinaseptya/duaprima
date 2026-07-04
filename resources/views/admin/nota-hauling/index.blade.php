@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">🚛 Verifikasi Nota Hauling</h1>
        <div class="no-print">
            <a href="{{ route('admin.nota-hauling.export') }}" class="btn btn-sm btn-danger shadow-sm">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Export PDF Laporan
            </a>
            <button onclick="window.print()" class="btn btn-sm btn-outline-dark shadow-sm">
                <i class="fas fa-print fa-sm"></i> Print Halaman Ini
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="font-size: 0.9rem;">
                    <thead class="bg-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Info Sopir</th>
                            <th>Tanggal Perjalanan</th>
                            <th>Dokumen</th>
                            <th>Biaya & Ritase</th>
                            <th>Status Verifikasi</th>
                            <th class="no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($notas as $nota)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($notas->currentPage() - 1) * $notas->perPage() }}</td>
                            <td>
                                <strong>{{ $nota->sopir->nama ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $nota->sopir->user->name ?? '' }}</small>
                            </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($nota->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    @if($nota->file_nota)
                                        <a href="{{ asset('storage/'.$nota->file_nota) }}" target="_blank" class="btn btn-outline-primary" title="Lihat Nota">
                                            <i class="fas fa-file-invoice"></i> Nota
                                        </a>
                                    @endif
                                    @if($nota->bukti_transfer)
                                        <a href="{{ asset('storage/'.$nota->bukti_transfer) }}" target="_blank" class="btn btn-outline-success" title="Lihat Transfer">
                                            <i class="fas fa-money-check-alt"></i> Bukti
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Ritase:</span>
                                    <strong>{{ $nota->jumlah_ritase }} Rit</strong>
                                </div>
                                <div class="d-flex justify-content-between text-success">
                                    <span>Tarif:</span>
                                    <strong>Rp {{ number_format($nota->tarif_per_rit, 0, ',', '.') }}</strong>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill 
                                    @if($nota->status === 'APPROVED') bg-success
                                    @elseif($nota->status === 'REJECTED') bg-danger
                                    @else bg-warning text-dark
                                    @endif">
                                    <i class="fas fa-circle fa-xs me-1"></i> {{ $nota->status ?? 'MENUNGGU' }}
                                </span>
                            </td>
                            <td class="text-center no-print">
                                {{-- Jika status masih MENUNGGU, tampilkan tombol aksi --}}
                                @if($nota->status === 'MENUNGGU' || !$nota->status)
                                    <form action="{{ route('admin.nota-hauling.update-status', $nota->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button name="status" value="APPROVED" class="btn btn-sm btn-success" onclick="return confirm('Setujui nota ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button name="status" value="REJECTED" class="btn btn-sm btn-danger" onclick="return confirm('Tolak nota ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada kiriman nota perjalanan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $notas->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .table { width: 100% !important; }
    }
</style>
@endsection