@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Sparepart')

@section('content')
<div class="container-fluid py-4">
    {{-- Header: Tombol Tambah Dihapus --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Inventaris Sparepart</h1>
        {{-- Tombol tambah sudah tidak ada di sini --}}
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

    {{-- Tabel Sparepart --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-boxes mr-2"></i> Stok Suku Cadang</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush m-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Sparepart</th>
                            <th class="text-center">Stok</th>
                            <th>Satuan</th>
                            <th>Supplier</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spareparts as $index => $sparepart)
                            <tr>
                                <td class="text-center font-weight-bold text-muted">
                                    {{ $spareparts->firstItem() + $index }}
                                </td>
                                <td class="font-weight-bold text-gray-800">
                                    {{ $sparepart->nama_sparepart }}
                                </td>
                                <td class="text-center">
                                    <span class="h6 mb-0 font-weight-bold">{{ $sparepart->stok }}</span>
                                </td>
                                <td><span class="badge badge-light border">{{ $sparepart->satuan }}</span></td>
                                <td><i class="fas fa-truck-loading small mr-1 text-muted"></i> {{ $sparepart->supplier ?? '-' }}</td>
                                <td class="text-center">
                                    @if($sparepart->stok <= 0)
                                        <span class="badge badge-danger">Habis</span>
                                    @elseif($sparepart->stok <= 5)
                                        <span class="badge badge-warning text-white">Hampir Habis</span>
                                    @else
                                        <span class="badge badge-success">Tersedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.sparepart.edit', $sparepart->id) }}" class="btn btn-sm btn-outline-warning mr-2" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.sparepart.destroy', $sparepart->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus sparepart {{ $sparepart->nama_sparepart }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3"></i>
                                        <p>Data sparepart belum tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($spareparts->hasPages())
        <div class="card-footer bg-white border-0 py-3 text-center">
            {{ $spareparts->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@endsection