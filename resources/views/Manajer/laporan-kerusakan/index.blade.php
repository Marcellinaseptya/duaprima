@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Laporan Kerusakan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Laporan Kerusakan</h3>
    <p class="text-muted">Daftar laporan kerusakan dari sopir. Manajer dapat memverifikasi dan membuat data maintenance.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Truk</th>
                        <th>Sopir</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kerusakan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->mastertruk->plat_nomor ?? '-' }}</td>
                            <td>{{ $item->sopir->user->nama ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->deskripsi_kerusakan, 50) }}</td>
                            <td>
                                <span class="badge
                                    @if($item->status == 'PENDING') bg-warning
                                    @elseif($item->status == 'DISETUJUI') bg-success
                                    @elseif($item->status == 'DITOLAK') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst(strtolower($item->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('manajer.kerusakan.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada laporan kerusakan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
