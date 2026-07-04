@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Maintenance')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-3">Data Maintenance</h1>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Filter Tanggal --}}
    <form method="GET" action="{{ route('admin.maintenance.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="date" name="from" value="{{ request('from') }}" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" value="{{ request('to') }}" class="form-control" placeholder="Sampai Tanggal">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('admin.maintenance.export', request()->all()) }}" class="btn btn-danger">Export PDF</a>
            </div>
        </div>
    </form>

    {{-- Tabel Maintenance --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Truk</th>
                        <th>Kerusakan</th>
                        <th>Tanggal</th>
                        <th>Biaya</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($maintenances as $index => $m)
                        <tr>
                            <td>{{ $maintenances->firstItem() + $index }}</td>
                            <td>{{ $m->mastertruk->plat_nomor ?? '-' }}</td>
                            <td>{{ $m->laporan->deskripsi_kerusakan ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($m->tanggal_perbaikan)->format('d-m-Y') }}</td>
                            <td>Rp{{ number_format($m->biaya_servis, 0, ',', '.') }}</td>
                            <td>
                                @if ($m->foto_bukti)
                                    <a href="{{ asset('storage/' . $m->foto_bukti) }}" target="_blank">Lihat Bukti</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data maintenance.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-footer d-flex justify-content-center">
            {{ $maintenances->links() }}
        </div>
    </div>
</div>
@endsection
