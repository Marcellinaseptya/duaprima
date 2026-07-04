@extends('layout.main')

@include('partials.sidebar-admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Jadwal Operasional</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{-- 🔍 Filter Tanggal --}}
                <form action="{{ route('jadwal-operasional') }}" method="GET" class="form-inline mb-3">
                    <div class="form-group mr-2">
                        <label for="tanggal" class="mr-2">Filter Tanggal:</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="{{ request('tanggal') }}">
                    </div>
                    <button type="submit" class="btn btn-secondary">Terapkan</button>
                </form>
                <a href="{{ route('jadwal.cetak', ['tanggal' => request('tanggal')]) }}" target="_blank" class="btn btn-dark mb-3">
    <i class="fas fa-print"></i> Cetak Laporan
</a>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Jadwal Operasional</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search" disabled>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default" disabled>
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
                                    <th>Sopir</th>
                                    <th>Tujuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwals as $i => $jadwal)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $jadwal->tanggal }}</td>
                                    <td>{{ $jadwal->sopir->nama ?? '-' }}</td>
                                    <td>{{ $jadwal->tujuan }}</td>
                                    <td>{{ $jadwal->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Belum ada data jadwal operasional.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->

            </div>
        </div>
    </div>
</section>
</div>

@endsection