@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Trip Pulang')

@section('content')
<div class="container mt-4">
    <h3>🚚 Daftar Trip Pulang</h3>
    <p class="text-muted">Lengkapi data pulang untuk trip yang sudah selesai perjalanan.</p>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Klien</th>
                        <th>Truk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tripPulang as $jadwal)
                        <tr class="text-center align-middle">
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                            <td>{{ $jadwal->klien->nama_perusahaan ?? '-' }}</td>
                            <td>{{ $jadwal->mastertruk->plat_nomor ?? '-' }}</td>
                            <td>
                                @if($jadwal->status == 'Pulang' || $jadwal->status == 'Berangkat')
                                    <span class="badge bg-warning text-dark">⏳ {{ $jadwal->status }}</span>
                                @elseif($jadwal->status == 'Selesai')
                                    <span class="badge bg-success">✅ Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ $jadwal->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if(in_array($jadwal->status, ['Berangkat', 'Pulang']))
                                    <a href="{{ route('sopir.trip-pulang.form', $jadwal->id) }}" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-clipboard-list"></i> Isi Form Pulang
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> Tidak ada trip yang perlu diisi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection