@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Edit Jadwal Operasional')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Edit Jadwal Operasional</h4>

    {{-- Alert Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('manajer.jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required 
                        value="{{ old('tanggal', $jadwal->tanggal) }}">
                </div>

                <div class="mb-3">
                    <label for="sopir_id" class="form-label">Sopir <span class="text-danger">*</span></label>
                    <select name="sopir_id" id="sopir_id" class="form-select" required>
                        <option value="">-- Pilih Sopir --</option>
                        @foreach($sopir as $s)
                            <option value="{{ $s->id }}" 
                                {{ old('sopir_id', $jadwal->sopir_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->user->nama ?? $s->user->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="mastertruk_id" class="form-label">Truk <span class="text-danger">*</span></label>
                    <select name="mastertruk_id" id="mastertruk_id" class="form-select" required>
                        <option value="">-- Pilih Truk --</option>
                        @foreach($mastertruk as $t)
                            <option value="{{ $t->id }}" 
                                {{ old('mastertruk_id', $jadwal->mastertruk_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->plat_nomor ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="klien_id" class="form-label">Klien</label>
                    <select name="klien_id" id="klien_id" class="form-select">
                        <option value="">-- Pilih Klien --</option>
                        @foreach($kliens as $klien)
                            <option value="{{ $klien->id }}" 
                                {{ old('klien_id', $jadwal->klien_id) == $klien->id ? 'selected' : '' }}>
                                {{ $klien->nama_perusahaan ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tujuan" class="form-label">Tujuan <span class="text-danger">*</span></label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control" required
                        value="{{ old('tujuan', $jadwal->tujuan) }}" placeholder="Contoh: Pelabuhan">
                </div>

                <div class="mb-3">
                    <label for="rute" class="form-label">Rute</label>
                    <input type="text" name="rute" id="rute" class="form-control" 
                        value="{{ old('rute', $jadwal->rute) }}" placeholder="Contoh: Pelabuhan - Tambang">
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="3" 
                        placeholder="Opsional">{{ old('catatan', $jadwal->catatan) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                    <a href="{{ route('manajer.jadwal.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
