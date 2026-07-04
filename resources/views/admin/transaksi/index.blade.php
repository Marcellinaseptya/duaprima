@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Transaksi Keuangan')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-3">Data Transaksi Keuangan</h1>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.transaksi.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <label>Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-3">
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">-- Semua --</option>
                    <option value="pemasukan" {{ request('kategori') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ request('kategori') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2">Filter</button>
                <a href="{{ route('admin.transaksi.export', request()->all()) }}" class="btn btn-danger">Export PDF</a>
            </div>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ ucfirst($transaksi->jenis) }}</td>
                            <td>Rp{{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if ($transaksi->kategori == 'pemasukan')
                                    <span class="badge badge-success">Pemasukan</span>
                                @else
                                    <span class="badge badge-danger">Pengeluaran</span>
                                @endif
                            </td>
                            <td>{{ $transaksi->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $transaksis->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection