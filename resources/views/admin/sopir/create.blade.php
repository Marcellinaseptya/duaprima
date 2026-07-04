@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="container">
    <h3>Tambah Data Sopir</h3>

    <form action="{{ route('admin.sopir.store') }}" method="POST">
        @csrf

        <!-- Dropdown User Login -->
        <div class="form-group">
            <label for="user_id">User Login</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option 
                        value="{{ $user->id }}"
                        data-nama="{{ $user->nama }}"
                        {{ old('user_id') == $user->id ? 'selected' : '' }}
                    >
                        {{ $user->nama }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>
        {{-- TAMBAHKAN KODE INI UNTUK MELIHAT ERRORNYA --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops! Ada yang salah:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- AKHIR KODE ERROR --}}
        <!-- Nama Sopir (otomatis dari user) -->
        <div class="form-group">
            <label for="nama">Nama Sopir</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" readonly required>
        </div>

        <!-- Alamat (manual) -->
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
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

        <!-- Status Aktif -->
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <!-- Pilihan Truk -->
        <div class="form-group">
            <label for="mastertruk_id">Truk yang Digunakan (Opsional)</label>
            <select name="mastertruk_id" id="mastertruk_id" class="form-control">
                <option value="">-- Pilih Truk --</option>
                @foreach ($availableTruks as $truk)
                    <option value="{{ $truk->id }}" {{ old('mastertruk_id') == $truk->id ? 'selected' : '' }}>
                        {{ $truk->plat_nomor }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.sopir.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<!-- Script untuk ambil nama otomatis -->
<script>
    document.getElementById('user_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const nama = selected.getAttribute('data-nama');
        document.getElementById('nama').value = nama;
    });
</script>
@endsection