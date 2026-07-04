@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<!-- Header -->
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Data Perbaikan Truk</h1>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Tombol Tambah -->
        <a href="{{ route('perbaikan.create') }}" class="btn btn-primary mb-3">Tambah Perbaikan</a>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('perbaikan.index') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label class="mr-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="form-group mr-2">
                <label class="mr-1">Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
            </div>
            <div class="form-group mr-2">
                <label class="mr-1">Sopir</label>
                <select name="sopir_id" class="form-control">
                    <option value="">-- Semua Sopir --</option>
                    @foreach ($sopirs as $sopir)
                        <option value="{{ $sopir->id }}" {{ request('sopir_id') == $sopir->id ? 'selected' : '' }}>
                            {{ $sopir->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Filter</button>
            <a href="{{ route('perbaikan.export', request()->all()) }}" class="btn btn-success" target="_blank">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </form>

        <!-- Tabel -->
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped text-nowrap bg-white">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sopir</th>
                            <th>Plat Truk</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Tanggal Perbaikan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perbaikans as $index => $perbaikan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $perbaikan->sopir->nama ?? '-' }}</td>
                            <td>{{ $perbaikan->truk->plat_nomor ?? '-' }}</td>
                            <td>{{ $perbaikan->keluhan }}</td>
                            <td>
                                <span class="badge bg-{{ $perbaikan->status == 'Selesai' ? 'success' : 'warning' }}">
                                    {{ $perbaikan->status }}
                                </span>
                            </td>
                            <td>
                                @if ($perbaikan->foto && file_exists(public_path($perbaikan->foto)))
                                    <img src="{{ asset($perbaikan->foto) }}" alt="Foto" width="80">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($perbaikan->tanggal_perbaikan)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('perbaikan.edit', $perbaikan->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-{{ $perbaikan->id }}">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modal-hapus-{{ $perbaikan->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <form method="POST" action="{{ route('perbaikan.destroy', $perbaikan->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Yakin ingin menghapus data perbaikan dari <strong>{{ $perbaikan->sopir->nama }}</strong>?
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data perbaikan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.container-fluid -->
</section>
@endsection