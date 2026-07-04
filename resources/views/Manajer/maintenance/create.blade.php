@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Tambah Jadwal Operasional')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Tambah Jadwal Operasional</h4>

    <form action="{{ route('manajer.jadwal.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            {{-- Tanggal --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <label for="tanggal" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                </div>
            </div>

            {{-- Sopir --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <label for="sopir_id" class="form-label"><i class="fas fa-user-tie me-2"></i>Sopir</label>
                    <select name="sopir_id" id="sopir_id" class="form-select" required>
                        <option value="">Pilih Sopir</option>
                        @foreach($sopir as $s)
                            <option value="{{ $s->id }}" {{ old('sopir_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->user->name ?? $s->user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Truk --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <label for="mastertruk_id" class="form-label"><i class="fas fa-truck me-2"></i>Truk</label>
                    <select name="mastertruk_id" id="mastertruk_id" class="form-select" required>
                        <option value="">Pilih Truk</option>
                        @foreach($mastertruk as $t)
                            <option value="{{ $t->id }}" {{ old('mastertruk_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->plat_nomor }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Klien --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <label for="klien_id" class="form-label"><i class="fas fa-building me-2"></i>Klien</label>
                    <select name="klien_id" id="klien_id" class="form-select">
                        <option value="">Pilih Klien</option>
                        @foreach($kliens as $k)
                            <option value="{{ $k->id }}" {{ old('klien_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_perusahaan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tujuan --}}
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <label for="tujuan" class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Tujuan</label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control" value="{{ old('tujuan') }}" placeholder="Contoh: Pelabuhan A" required>
                </div>
            </div>

            {{-- Rute --}}
            <div class="col-12">
                <div class="card shadow-sm p-3">
                    <label for="rute" class="form-label"><i class="fas fa-route me-2"></i>Rute</label>
                    <input type="text" name="rute" id="rute" class="form-control" value="{{ old('rute') }}" placeholder="Contoh: A – B – C">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="col-12 text-end mt-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Jadwal</button>
                <a href="{{ route('manajer.jadwal.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-times me-1"></i>Batal</a>
            </div>
        </div>

        {{-- Status default --}}
        <input type="hidden" name="status" value="Siap Berangkat">
    </form>
</div>
@endsection
