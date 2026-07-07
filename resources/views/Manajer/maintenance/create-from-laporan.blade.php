@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Buat Data Maintenance')

@section('content')
<div class="container-fluid py-4 mb-5 pb-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Buat Data Maintenance</h1>
        <p class="mb-0 text-muted">Dari Laporan Kerusakan</p>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white font-weight-bold">
            Detail Laporan Kerusakan
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tanggal Laporan:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}</p>
                    <p class="mb-1"><strong>Sopir:</strong> {{ $laporan->sopir->user->name ?? $laporan->sopir->nama ?? '-' }}</p>
                    <p class="mb-1"><strong>Truk:</strong> {{ $laporan->mastertruk->plat_nomor ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Keluhan/Deskripsi:</strong> <br> {{ $laporan->deskripsi_kerusakan }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <form action="{{ route('manajer.maintenance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="laporan_kerusakan_id" value="{{ $laporan->id }}">
                
                <div class="row g-3">
                    {{-- Truk --}}
                    <div class="col-md-6 mb-3">
                        <label for="mastertruk_id" class="form-label font-weight-bold">Truk yang Diperbaiki</label>
                        <select name="mastertruk_id" id="mastertruk_id" class="form-control" required>
                            <option value="">-- Pilih Truk --</option>
                            @foreach($mastertruk as $t)
                                <option value="{{ $t->id }}" {{ $laporan->mastertruk_id == $t->id ? 'selected' : '' }}>
                                    {{ $t->plat_nomor }}
                                </option>
                            @endforeach
                        </select>
                        @error('mastertruk_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tanggal Perbaikan --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_perbaikan" class="form-label font-weight-bold">Tanggal Perbaikan</label>
                        <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan" class="form-control" value="{{ old('tanggal_perbaikan', date('Y-m-d')) }}" required>
                        @error('tanggal_perbaikan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Deskripsi Perbaikan --}}
                    <div class="col-12 mb-3">
                        <label for="deskripsi_perbaikan" class="form-label font-weight-bold">Tindakan / Deskripsi Perbaikan</label>
                        <textarea name="deskripsi_perbaikan" id="deskripsi_perbaikan" class="form-control" rows="3" required placeholder="Tuliskan tindakan perbaikan yang dilakukan beserta sparepart yang diganti (jika ada)...">{{ old('deskripsi_perbaikan') }}</textarea>
                        @error('deskripsi_perbaikan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Biaya Servis --}}
                    <div class="col-md-6 mb-3">
                        <label for="biaya_servis" class="form-label font-weight-bold">Total Biaya Servis (Rp)</label>
                        <input type="text" name="biaya_servis" id="biaya_servis" class="form-control rupiah-input" value="{{ old('biaya_servis') }}" required placeholder="Contoh: 500.000">
                        @error('biaya_servis')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Foto Bukti (Nota/Invoice/Foto Perbaikan) --}}
                    <div class="col-md-6 mb-3">
                        <label for="foto_bukti" class="form-label font-weight-bold">Upload Bukti Servis / Nota</label>
                        <input type="file" name="foto_bukti" id="foto_bukti" class="form-control-file" accept="image/*,.pdf">
                        <small class="text-muted d-block mt-1">Opsional. Format: JPG, PNG, atau PDF (Maks 2MB)</small>
                        @error('foto_bukti')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="col-12 text-right mt-4 border-top pt-3">
                        <a href="{{ route('manajer.kerusakan.show', $laporan->id) }}" class="btn btn-secondary mr-2 px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save mr-1"></i> Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
