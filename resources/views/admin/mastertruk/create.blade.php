@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Tambah Data Truk')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-3">Tambah Data Truk</h1>

    <form method="POST" action="{{ route('admin.mastertruk.store') }}">
        @csrf

        <!-- Plat Nomor -->
        <div class="form-group mb-3">
            <label>Plat Nomor</label>
            <input type="text" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror"
                value="{{ old('plat_nomor') }}" required>
            @error('plat_nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Tahun -->
        <div class="form-group mb-3">
            <label for="tahun">Tahun</label>
            <select name="tahun" class="form-control @error('tahun') is-invalid @enderror" required>
                <option value="">-- Pilih Tahun --</option>
                @for ($i = date('Y'); $i >= 1990; $i--)
                    <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Merk -->
        <div class="form-group mb-3">
            <label>Merk</label>
            <select name="merk" class="form-control @error('merk') is-invalid @enderror" required>
                <option value="">-- Pilih Merk --</option>
                @foreach($merkList as $merk)
                    <option value="{{ $merk }}" {{ old('merk') == $merk ? 'selected' : '' }}>{{ $merk }}</option>
                @endforeach
            </select>
            @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Jenis Truk -->
        <div class="form-group mb-3">
            <label>Jenis Truk</label>
            <select name="jenis_truk" class="form-control @error('jenis_truk') is-invalid @enderror" required>
                <option value="">-- Pilih Jenis Truk --</option>
                <option value="Dump Truck" {{ old('jenis_truk') == 'Dump Truck' ? 'selected' : '' }}>Dump Truck</option>
                <option value="Tronton" {{ old('jenis_truk') == 'Tronton' ? 'selected' : '' }}>Tronton</option>
                <option value="Engkel" {{ old('jenis_truk') == 'Engkel' ? 'selected' : '' }}>Engkel</option>
                <option value="Wingbox" {{ old('jenis_truk') == 'Wingbox' ? 'selected' : '' }}>Wingbox</option>
            </select>
            @error('jenis_truk') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Warna -->
        <div class="form-group mb-3">
            <label>Warna</label>
            <select name="warna" class="form-control @error('warna') is-invalid @enderror" required>
                <option value="">-- Pilih Warna --</option>
                <option value="Merah" {{ old('warna') == 'Merah' ? 'selected' : '' }}>Merah</option>
                <option value="Biru" {{ old('warna') == 'Biru' ? 'selected' : '' }}>Biru</option>
                <option value="Hitam" {{ old('warna') == 'Hitam' ? 'selected' : '' }}>Hitam</option>
                <option value="Putih" {{ old('warna') == 'Putih' ? 'selected' : '' }}>Putih</option>
                <option value="Kuning" {{ old('warna') == 'Kuning' ? 'selected' : '' }}>Kuning</option>
            </select>
            @error('warna') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Kapasitas -->
        <div class="form-group mb-3">
            <label>Kapasitas (kg)</label>
            <select name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" required>
                <option value="">-- Pilih Kapasitas --</option>
                <option value="5000" {{ old('kapasitas') == 5000 ? 'selected' : '' }}>5000</option>
                <option value="8000" {{ old('kapasitas') == 8000 ? 'selected' : '' }}>8000</option>
                <option value="10000" {{ old('kapasitas') == 10000 ? 'selected' : '' }}>10000</option>
                <option value="12000" {{ old('kapasitas') == 12000 ? 'selected' : '' }}>12000</option>
                <option value="16000" {{ old('kapasitas') == 16000 ? 'selected' : '' }}>16000</option>
            </select>
            @error('kapasitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Status -->
        <div class="form-group mb-3">
            <label>Status Truk</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">-- Pilih Status --</option>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="servis" {{ old('status') == 'servis' ? 'selected' : '' }}>Servis</option>
                <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Keterangan -->
        <div class="form-group mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.mastertruk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
