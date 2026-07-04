@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Tambah Klien')

@section('content')
<div class="container mt-4">
    <h1>Tambah Klien</h1>

    <form action="{{ route('admin.klien.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan') }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
        </div>

         <!-- Nomor HP -->
         <div class="form-group mb-3">
            <label>Nomor HP / WhatsApp</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    {{-- PERBAIKAN: +652 diubah menjadi +62 --}}
                    <span class="input-group-text">+62</span>
                </div>
                {{-- Pengguna mengetik dari angka 8... --}}
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                    placeholder="81234567890" value="{{ old('no_hp') }}" required>
                
                {{-- Pesan Error Validasi --}}
                @error('no_hp') 
                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ old('status')=='aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status')=='nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.klien.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
