@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Detail Laporan Kerusakan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Detail Laporan Kerusakan</h3>

    <div class="card">
        <div class="card-body">
            <!-- Tanggal -->
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</p>

            <!-- Sopir -->
            <p><strong>Sopir:</strong> {{ $laporan->sopir->user->name ?? $laporan->sopir->nama ?? 'Tidak diketahui' }}</p>

            <!-- Truk -->
            <p><strong>Truk:</strong> {{ $laporan->mastertruk->plat_nomor ?? 'Tidak diketahui' }}</p>

            <!-- Deskripsi -->
            <p><strong>Deskripsi Kerusakan:</strong><br>{{ $laporan->deskripsi_kerusakan }}</p>

            <!-- Status -->
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($laporan->status == 'PENDING') bg-warning 
                    @elseif($laporan->status == 'DISETUJUI') bg-success 
                    @elseif($laporan->status == 'DITOLAK') bg-danger 
                    @endif">
                    {{ ucfirst(strtolower($laporan->status)) }}
                </span>
            </p>

            <!-- Alasan penolakan -->
            @if($laporan->status === 'DITOLAK' && $laporan->alasan_penolakan)
                <p><strong>Alasan Ditolak:</strong><br>{{ $laporan->alasan_penolakan }}</p>
            @endif

            <!-- Foto bukti -->
            <p><strong>Foto Bukti:</strong><br>
                @if($laporan->foto)
                    <img src="{{ asset('storage/' . $laporan->foto) }}" width="300" class="img-thumbnail">
                @else
                    <em>Tidak ada foto yang diunggah.</em>
                @endif
            </p>

            <!-- Tombol approve / reject -->
            @if ($laporan->status == 'PENDING')
            <div class="mt-4">
                <form action="{{ route('manajer.kerusakan.setujui', $laporan->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success">✅ Setujui</button>
                </form>

                <form action="{{ route('manajer.kerusakan.tolak', $laporan->id) }}" method="POST" class="d-inline ms-2">
                    @csrf
                    @method('PUT')
                    <div class="input-group">
                        <input type="text" name="alasan_penolakan" class="form-control" placeholder="Alasan penolakan" required>
                        <button class="btn btn-danger">❌ Tolak</button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Tombol buat maintenance -->
            @if ($laporan->status === 'DISETUJUI' && !$laporan->maintenance)
            <div class="mt-4">
                <a href="{{ route('manajer.maintenance.fromLaporan', $laporan->id) }}" class="btn btn-primary">
                    🛠️ Buat Maintenance dari Laporan Ini
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
