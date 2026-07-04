@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="container mt-4">
    <h3>Edit Data Perbaikan</h3>

    <form action="{{ route('perbaikan.update', $perbaikan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="sopir_id">Sopir</label>
            <select name="sopir_id" class="form-control" required>
                <option value="">-- Pilih Sopir --</option>
                @foreach($sopirs as $sopir)
                    <option value="{{ $sopir->id }}" {{ $perbaikan->sopir_id == $sopir->id ? 'selected' : '' }}>
                        {{ $sopir->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="mastertruk_id">Truk</label>
            <select name="mastertruk_id" class="form-control" required>
                <option value="">-- Pilih Truk --</option>
                @foreach($truks as $truk)
                    <option value="{{ $truk->id }}" {{ $perbaikan->mastertruk_id == $truk->id ? 'selected' : '' }}>
                        {{ $truk->plat_nomor }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
            <input type="date" name="tanggal_perbaikan" class="form-control" value="{{ $perbaikan->tanggal_perbaikan }}" required>
        </div>

        <div class="form-group">
            <label for="keluhan">Keluhan</label>
            <input type="text" name="keluhan" class="form-control" value="{{ $perbaikan->keluhan }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status Perbaikan</label>
            <select name="status" class="form-control" required>
                <option value="PENDING" {{ $perbaikan->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                <option value="PROSES" {{ $perbaikan->status == 'PROSES' ? 'selected' : '' }}>PROSES</option>
                <option value="SELESAI" {{ $perbaikan->status == 'SELESAI' ? 'selected' : '' }}>SELESAI</option>
            </select>
        </div>

        <div class="form-group">
            <label for="foto">Foto (Opsional)</label><br>
            @if ($perbaikan->foto && file_exists(public_path($perbaikan->foto)))
                <img src="{{ asset($perbaikan->foto) }}" width="100" class="mb-2"><br>
            @endif
            <input type="file" name="foto" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('perbaikan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection