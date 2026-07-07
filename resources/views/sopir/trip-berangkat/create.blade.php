@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Mulai Trip Baru')

@section('content')
<div class="container mt-4">
    <h3>Mulai Perjalanan Baru</h3>
    <p class="text-muted">Masukkan data awal untuk memulai trip Anda.</p>

    <div class="card shadow-sm p-4">
        <form action="{{ route('sopir.trip-berangkat.store') }}" method="POST">
            @csrf

            <!-- Tanggal Berangkat -->
            <div class="mb-3">
                <label class="form-label">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <!-- Klien (Tujuan) -->
            <div class="mb-3">
                <label class="form-label">Klien Tujuan (Opsional)</label>
                <select name="klien_id" class="form-control">
                    <option value="">-- Pilih Klien Tujuan --</option>
                    @foreach($kliens as $klien)
                        <option value="{{ $klien->id }}">{{ $klien->nama_perusahaan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Lokasi Awal -->
            <div class="mb-3">
                <label class="form-label">Lokasi Awal (Keberangkatan)</label>
                <input type="text" name="lokasi_berangkat" class="form-control" placeholder="Contoh: Pool Truk Banjarmasin" required>
            </div>

            <!-- KM Awal -->
            <div class="mb-3">
                <label class="form-label">KM Awal Truk</label>
                <input type="number" name="km_awal" class="form-control" placeholder="Contoh: 154000" required>
            </div>

            <!-- Catatan -->
            <div class="mb-3">
                <label class="form-label">Catatan (Opsional)</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Mulai Perjalanan</button>
                <a href="{{ route('sopir.trip-berangkat.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
