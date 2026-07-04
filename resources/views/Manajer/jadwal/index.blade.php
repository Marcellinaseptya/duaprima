@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Jadwal Operasional')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Jadwal Operasional</h4>
        <a href="{{ route('manajer.jadwal.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Sopir</th>
                        <th>Truk</th>
                        <th>Klien</th>
                        <th>Tujuan</th>
                        <th>Rute</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $i => $jadwal)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $jadwal->sopir->user->nama ?? '-' }}</td>
                            <td>{{ $jadwal->mastertruk->plat_nomor ?? '-' }}</td>
                            <td>{{ $jadwal->klien->nama_perusahaan ?? '-' }}</td>
                            <td>{{ $jadwal->tujuan ?? '-' }}</td>
                            <td>{{ $jadwal->rute ?? '-' }}</td>
                            <td>
                                @php
                                    $status = $jadwal->status ?? '';
                                    $badge = match($status) {
                                        'Menunggu' => 'bg-secondary',
                                        'Siap Berangkat' => 'bg-info',
                                        'Berangkat' => 'bg-primary',
                                        'Pulang' => 'bg-warning',
                                        'Selesai' => 'bg-success',
                                        'Dibatalkan oleh Sopir' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ $status }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('manajer.jadwal.edit', $jadwal->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('manajer.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada jadwal operasional.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection