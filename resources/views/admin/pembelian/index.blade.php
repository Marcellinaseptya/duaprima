@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Pembelian Sparepart')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Riwayat Pembelian Sparepart</h1>
        <a href="{{ route('admin.pembelian.create') }}" class="btn btn-primary shadow-sm text-white">
            <i class="fas fa-cart-plus fa-sm text-white-50"></i> Tambah Pembelian
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Tabel Pembelian --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history mr-2"></i> Daftar Transaksi Masuk</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush m-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Sparepart</th>
                            <th class="text-center">Qty</th>
                            <th>Harga Total</th>
                            <th>Supplier</th>
                            <th>Tanggal</th>
                            <th>Nota</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelian as $index => $item)
                            <tr>
                                <td class="text-center font-weight-bold text-muted">
                                    {{ $pembelian->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="font-weight-bold text-gray-800">{{ $item->sparepart->nama_sparepart ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ Str::limit($item->catatan, 30) ?? '-' }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info shadow-sm">{{ $item->jumlah }}</span>
                                </td>
                                <td class="font-weight-bold text-dark">
                                    Rp{{ number_format($item->harga_total, 0, ',', '.') }}
                                </td>
                                <td><i class="fas fa-store-alt small mr-1 text-muted"></i> {{ $item->supplier }}</td>
                                <td>
                                    <span class="text-sm text-nowrap"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}</span>
                                </td>
                                <td>
                                    @if($item->nota)
                                        <a href="{{ asset('storage/' . $item->nota) }}" target="_blank" class="btn btn-xs btn-outline-primary shadow-sm">
                                            <i class="fas fa-file-download mr-1"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted small italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        {{-- FIX: Route Edit --}}
                                        <a href="{{ route('admin.pembelian.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        
                                        {{-- FIX: Route Hapus --}}
                                        <form action="{{ route('admin.pembelian.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus riwayat pembelian ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-shopping-cart fa-3x text-light mb-3"></i>
                                    <p class="text-muted">Belum ada transaksi pembelian.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($pembelian->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $pembelian->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        vertical-align: middle;
    }
    .text-sm { font-size: 0.85rem; }
    .btn-xs { padding: 0.2rem 0.4rem; font-size: 0.7rem; }
    .italic { font-style: italic; }
</style>
@endsection