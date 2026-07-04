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
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <label for="tanggal" class="form-label">📅 Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Sopir --}}
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <label for="sopir_id" class="form-label">🚚 Sopir</label>
                    <select name="sopir_id" id="sopir_id" class="form-select @error('sopir_id') is-invalid @enderror" required>
                        <option value="">Pilih Sopir</option>
                        @foreach($sopir as $s)
                            <option value="{{ $s->id }}" {{ old('sopir_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->user->nama ?? $s->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('sopir_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Truk --}}
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <label for="mastertruk_id" class="form-label">🚛 Truk</label>
                    <select name="mastertruk_id" id="mastertruk_id" class="form-select @error('mastertruk_id') is-invalid @enderror" required>
                        <option value="">Pilih Truk</option>
                        @foreach($mastertruk as $t)
                            <option value="{{ $t->id }}" {{ old('mastertruk_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->plat_nomor }}
                            </option>
                        @endforeach
                    </select>
                    @error('mastertruk_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Klien --}}
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <label for="klien_id" class="form-label">🏢 Klien</label>
                    <select name="klien_id" id="klien_id" class="form-select @error('klien_id') is-invalid @enderror">
                        <option value="">Pilih Klien</option>
                        @foreach($kliens as $k)
                            <option value="{{ $k->id }}" {{ old('klien_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_perusahaan }}
                            </option>
                        @endforeach
                    </select>
                    @error('klien_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tujuan --}}
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <label for="tujuan" class="form-label">🎯 Tujuan</label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control @error('tujuan') is-invalid @enderror" value="{{ old('tujuan') }}" required>
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Rute --}}
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <label for="rute" class="form-label">🛣 Rute</label>
                    <input type="text" name="rute" id="rute" class="form-control @error('rute') is-invalid @enderror" value="{{ old('rute') }}" placeholder="Contoh: A – B – C">
                    @error('rute')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Status default --}}
        <input type="hidden" name="status" value="Siap Berangkat">

        {{-- Tombol --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
            <a href="{{ route('manajer.jadwal.index') }}" class="btn btn-secondary ms-2">Batal</a>
        </div>
    </form>
</div>
@endsection
