@extends('layout.main')

@include('partials.sidebar-admin')
@section('content')


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pengeluaran</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <form method="GET" action="{{ route('pengeluaran') }}" class="form-inline mb-3">
    {{-- Tanggal --}}
    <input type="date" name="start_date" class="form-control mr-2" value="{{ request('start_date') }}">
    <input type="date" name="end_date" class="form-control mr-2" value="{{ request('end_date') }}">

    {{-- Sumber --}}
    <input type="text" name="sumber" class="form-control mr-2" placeholder="Sumber" value="{{ request('sumber') }}">

    {{-- Tombol --}}
    <button type="submit" class="btn btn-info mr-2">Filter</button>
    <a href="{{ route('pengeluaran.export', request()->all()) }}" class="btn btn-success">Export PDF</a>
</form>



                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pengeluaran</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Cari">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
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
                                    @foreach ($pengeluarans as $pengeluaran)
                                    <tr>
                        
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengeluaran->tanggal }}</td>
                                        <td>{{ $pengeluaran->sumber }}</td>
                                        <td>Rp{{ number_format($pengeluaran->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $pengeluaran->keterangan }}</td>
                                        <td>
                                            <a href="{{ route('pengeluaran.edit', $pengeluaran->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-{{ $pengeluaran->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="modal-hapus-{{ $pengeluaran->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $pengeluaran->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $pengeluaran->id }}">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Yakin ingin menghapus pengeluaran <strong>{{ $pengeluaran->nama_pengeluaran }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </div>
                                            </form>
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
