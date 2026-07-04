@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Nota Pengeluaran Sopir')

@section('content')
<div class="container-fluid mt-3">
    <h1>Nota Pengeluaran Sopir</h1>

    {{-- Filter Tanggal & Export --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-auto">
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.notapengeluaran.export', request()->all()) }}" class="btn btn-danger">Export PDF</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.notapengeluaran.create') }}" class="btn btn-success">Tambah Nota</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Sopir</th>
                    <th>Jenis Nota</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>File</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notaPengeluaran as $nota)
                    <tr>
                        <td>{{ $loop->iteration + ($notaPengeluaran->currentPage() - 1) * $notaPengeluaran->perPage() }}</td>
                        <td>{{ $nota->sopir->nama ?? '-' }}</td>
                        <td>{{ $nota->jenis }}</td>
                        <td>{{ $nota->keterangan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
                        <td>
                            @if($nota->file_bukti)
                                <a href="{{ Storage::url($nota->file_bukti) }}" target="_blank">Lihat File</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.nota-pengeluaran.show', $nota->id) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada nota yang diunggah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $notaPengeluaran->links() }}
        </div>
    </div>
</div>
@endsection
