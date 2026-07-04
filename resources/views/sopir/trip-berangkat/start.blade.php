@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Mulai Trip Berangkat')

@section('content')
<div class="container mt-4">
    <h3>Form Mulai Perjalanan</h3>
    <p>Lengkapi data sebelum memulai trip.</p>

    <div class="card p-3">
        <form action="{{ route('sopir.trip-berangkat.store', $jadwal->id) }}" 
              method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Info Jadwal / Klien -->
            <div class="mb-3">
                <label class="form-label">Jadwal / Klien</label>
                <input type="text" class="form-control" 
                       value="{{ $jadwal->klien->nama_perusahaan ?? 'Jadwal tidak ditemukan' }}" disabled>
                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
            </div>

            <!-- Lokasi berangkat -->
            <div class="mb-3">
                <label class="form-label">Lokasi Berangkat</label>
                <input type="text" class="form-control" name="lokasi_berangkat" required>
            </div>

            <!-- Uang Jalan -->
            <div class="mb-3">
                <label class="form-label">Uang Jalan (Rp)</label>
                <input type="number" class="form-control" name="uang_jalan" required>
            </div>

            <!-- Uang Makan -->
            <div class="mb-3">
                <label class="form-label">Uang Makan (Rp)</label>
                <input type="number" class="form-control" name="uang_makan" required>
            </div>

            <!-- Catatan -->
            <div class="mb-3">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="3"></textarea>
            </div>

            <!-- Upload Nota -->
            <div class="mb-3">
                <label class="form-label">Upload Nota Perjalanan (opsional)</label>
                <input type="file" name="nota_perjalanan" class="form-control">
            </div>

            <!-- Waktu Mulai -->
            <div class="mb-3">
                <label class="form-label">Waktu Mulai</label>
                <input type="datetime-local" class="form-control" name="waktu_mulai" 
                       value="{{ now()->format('Y-m-d\TH:i') }}" required>
            </div>

            <!-- Tombol -->
            <div class="mt-3">
                <button type="submit" class="btn btn-success">🚚 Mulai Perjalanan</button>
                <a href="{{ route('sopir.trip-berangkat.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection