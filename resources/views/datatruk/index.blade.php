@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Master Data Truk')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Armada Truk</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Master Truk</li>
            </ol>
        </nav>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        {{-- Kiri: Form Tambah --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary py-3">
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-plus-circle mr-2"></i> Tambah Truk Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('mastertruk.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="plat_nomor" class="font-weight-bold text-dark">Plat Nomor</label>
                            <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror" 
                                   name="plat_nomor" id="plat_nomor" placeholder="Contoh: B 1234 ABC" required>
                            @error('plat_nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis" class="font-weight-bold text-dark">Jenis Truk</label>
                            <select class="form-control" name="jenis" id="jenis">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Engkel">Engkel</option>
                                <option value="Colt Diesel">Colt Diesel</option>
                                <option value="Fuso">Fuso</option>
                                <option value="Tronton">Tronton</option>
                            </select>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary btn-block shadow-sm">
                            <i class="fas fa-save mr-1"></i> Simpan Data Truk
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kanan: Tabel Data --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-truck mr-2"></i> Daftar Armada</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center table-flush m-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="10%">No</th>
                                    <th>Plat Nomor</th>
                                    <th>Jenis</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mastertruks as $truk)
                                <tr>
                                    <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                                    <td><span class="badge badge-light p-2 border shadow-sm" style="font-size: 0.9rem;">{{ $truk->plat_nomor }}</span></td>
                                    <td>{{ $truk->jenis ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('mastertruk.edit', $truk->id) }}" class="btn btn-sm btn-outline-warning mr-2" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modal-hapus-{{ $truk->id }}" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Hapus --}}
                                <div class="modal fade" id="modal-hapus-{{ $truk->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header bg-danger text-white border-0">
                                                <h5 class="modal-title font-weight-bold">Konfirmasi Hapus</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                                                <p class="mb-0">Apakah Anda yakin ingin menghapus data truk:</p>
                                                <h4 class="font-weight-bold text-dark mt-2">{{ $truk->plat_nomor }}</h4>
                                                <small class="text-muted">Data yang sudah dihapus tidak bisa dikembalikan.</small>
                                            </div>
                                            <div class="modal-footer border-0 justify-content-center">
                                                <button type="button" class="btn btn-light px-4" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('mastertruk.destroy', $truk->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4 shadow-sm">Ya, Hapus!</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="fas fa-truck-loading fa-3x text-light mb-3"></i>
                                        <p class="text-muted">Belum ada data truk yang terdaftar.</p>
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
</div>

<style>
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .badge-light {
        background-color: #f8f9fc;
        color: #4e73df;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
    }
</style>
@endsection