@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Isi Form Pulang')

@section('content')
<div class="container mt-4">
    <h3>📝 Form Pulang Trip</h3>
    <p class="text-muted">Lengkapi data berikut setelah perjalanan selesai.</p>

    <div class="card shadow-sm p-4">
        <form action="{{ route('sopir.trip-pulang.store', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Klien -->
            <div class="mb-3">
                <label class="form-label">Klien</label>
                <input type="text" class="form-control"
                       value="{{ $jadwal->klien->nama_perusahaan ?? '-' }}" disabled>
            </div>

            <!-- Truk -->
            <div class="mb-3">
                <label class="form-label">Truk</label>
                <input type="text" class="form-control"
                       value="{{ $jadwal->mastertruk->plat_nomor ?? '-' }}" disabled>
            </div>

            <!-- Muatan Netto -->
            <div class="mb-3">
                <label class="form-label">Muatan Netto (Kg)</label>
                <input type="number" name="muatan_netto" class="form-control" placeholder="Contoh: 14000" required>
            </div>

            <!-- Jumlah Ritase -->
            <div class="mb-3">
                <label class="form-label">Jumlah Ritase</label>
                <input type="number" name="ritase" class="form-control" placeholder="Contoh: 1" required>
            </div>

            <!-- Uang Jalan -->
            <div class="mb-3">
                <label class="form-label">Uang Jalan (Rp)</label>
                <input type="number" name="uang_jalan" class="form-control" placeholder="Contoh: 50000" required>
            </div>

            <!-- Uang Makan -->
            <div class="mb-3">
                <label class="form-label">Uang Makan (Rp)</label>
                <input type="number" name="uang_makan" class="form-control" placeholder="Contoh: 30000" required>
            </div>

            <!-- Harga BBM -->
            <div class="mb-3">
                <label class="form-label">Harga BBM (Rp)</label>
                <input type="number" name="biaya_bbm" class="form-control" placeholder="Opsional">
            </div>

            <!-- Catatan -->
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
            </div>

            <!-- Upload Nota -->
            <div class="mb-3">
                <label class="form-label">Upload Nota BBM (Opsional)</label>
                <input type="file" name="nota_bbm" class="form-control">
                <small class="text-muted">Format: JPG, PNG, PDF (max 2MB)</small>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">🚚 Selesaikan Trip</button>
                <a href="{{ route('sopir.trip-pulang.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
