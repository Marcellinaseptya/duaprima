@extends('layout.main')
@include('partials.sidebar-admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Transaksi Pemasukan</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{-- Tombol Tambah dan Filter --}}
                <a href="{{ route('pemasukan.create') }}" class="btn btn-primary mb-3">Tambah Pemasukan</a>

                {{-- Filter Rentang Tanggal --}}
                <form method="GET" action="{{ route('pemasukan') }}" class="form-inline mb-3">
                    <label class="mr-2">Dari:</label>
                    <input type="date" name="tanggal_mulai" class="form-control mr-2" value="{{ request('tanggal_mulai') }}">

                    <label class="mr-2">Sampai:</label>
                    <input type="date" name="tanggal_sampai" class="form-control mr-2" value="{{ request('tanggal_sampai') }}">

                    <button type="submit" class="btn btn-info mr-2">Filter</button>
                    <a href="{{ route('pemasukan') }}" class="btn btn-secondary mr-2">Reset</a>
                    <a href="{{ route('pemasukan.export', request()->only('tanggal_mulai', 'tanggal_sampai')) }}" class="btn btn-success">Cetak PDF</a>
                </form>

                {{-- Card Tabel --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pemasukan</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search (manual)">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Sumber</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($pemasukans as $pemasukan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pemasukan->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $pemasukan->sumber }}</td>
                                    <td>Rp{{ number_format($pemasukan->nominal, 0, ',', '.') }}</td>
                                    <td>{{ $pemasukan->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('pemasukan.edit', $pemasukan->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-{{ $pemasukan->id }}">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="modal-hapus-{{ $pemasukan->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin ingin menghapus pemasukan dari <strong>{{ $pemasukan->sumber }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('pemasukan.destroy', $pemasukan->id) }}" method="POST">
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
</div>
@endsection