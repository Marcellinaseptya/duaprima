@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Daftar Faktur')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Daftar Faktur (Invoice)</h3>
        <a href="{{ route('manajer.faktur.create') }}" class="btn btn-primary">Tambah Faktur</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm p-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Klien</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fakturs as $f)
                <tr>
                    <td>{{ $f->kode_invoice }}</td>
                    <td>{{ $f->tanggal_invoice }}</td>
                    <td>{{ $f->klien->nama_perusahaan ?? '-' }}</td>
                    <td>Rp{{ number_format($f->total_tagihan) }}</td>
                    <td>
                        @if($f->status == 'sudah_bayar') <span class="badge bg-success">Lunas</span>
                        @elseif($f->status == 'dp') <span class="badge bg-warning">DP</span>
                        @else <span class="badge bg-danger">Belum Bayar</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('manajer.faktur.edit', $f->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data faktur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
