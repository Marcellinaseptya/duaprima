@extends('layout.main')
@include('partials.sidebar-sopir')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Laporkan Kerusakan</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form action="{{ route('sopir.laporan-kerusakan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Pilih Truk --}}
            <div class="form-group">
                <label for="mastertruk_id">Truk</label>
                <select name="mastertruk_id" id="mastertruk_id" 
                        class="form-control @error('mastertruk_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Truk --</option>
                    @foreach($truks as $truk)
                        <option value="{{ $truk->id }}" {{ old('mastertruk_id') == $truk->id ? 'selected' : '' }}>
                            {{ $truk->plat_nomor }}
                        </option>
                    @endforeach
                </select>
                @error('mastertruk_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div class="form-group">
                <label for="tanggal">Tanggal Laporan</label>
                <input type="date" name="tanggal" id="tanggal" 
                       class="form-control @error('tanggal') is-invalid @enderror"
                       value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Deskripsi Kerusakan --}}
            <div class="form-group">
                <label for="deskripsi_kerusakan">Deskripsi Kerusakan</label>
                <textarea name="deskripsi_kerusakan" id="deskripsi_kerusakan" 
                          class="form-control @error('deskripsi_kerusakan') is-invalid @enderror" rows="3" required>{{ old('deskripsi_kerusakan') }}</textarea>
                @error('deskripsi_kerusakan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Foto --}}
            <div class="form-group">
                <label for="foto">Foto (opsional)</label>
                <input type="file" name="foto" id="foto" 
                       class="form-control-file @error('foto') is-invalid @enderror">
                @error('foto')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Kirim Laporan</button>
        </form>
    </div>
</section>
@endsection