@extends('layout.main')

@include('partials.sidebar-admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Transaksi Keuangan</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>

                {{-- FILTER --}}
                <form method="GET" action="{{ route('peminjaman') }}" class="form-inline mb-3">
                    <div class="form-group mr-2">
                        <label class="mr-1">Dari</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="form-group mr-2">
                        <label class="mr-1">Sampai</label>
                        <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="form-group mr-2">
                        <input type="text" name="sumber" class="form-control" placeholder="Sumber" value="{{ request('sumber') }}">
                    </div>
                    <div class="form-group mr-2">
                        <select name="status" class="form-control">
                            <option value="">-- Status --</option>
                            <option value="LUNAS" {{ request('status') == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                            <option value="BELUM LUNAS" {{ request('status') == 'BELUM LUNAS' ? 'selected' : '' }}>BELUM LUNAS</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                    <a href="{{ route('peminjaman.export.pdf', request()->all()) }}" class="btn btn-success" target="_blank">Export PDF</a>
                </form>

                {{-- TABEL DATA --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Peminjaman</h3>
                    </div>
                    
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Sumber</th>
                                    <th>Nominal</th>
                                    <th>Terbayar</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Sopir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peminjaman as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->sumber }}</td>
                                    <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->terbayar ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->status_pelunasan == 'LUNAS')
                                            <span class="badge badge-success">LUNAS</span>
                                        @else
                                            <span class="badge badge-warning">BELUM LUNAS</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->sopir->nama ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('peminjaman.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-{{ $item->id }}">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Hapus --}}
                                <div class="modal fade" id="modal-hapus-{{ $item->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin ingin menghapus transaksi dari <strong>{{ $item->sumber }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection
