@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Edit Sopir')

@section('content')
<div class="container mt-4">
    <h1>Edit Sopir</h1>

    <form action="{{ route('admin.sopir.update', $sopir->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Dropdown User -->
        <div class="form-group mb-3">
            <label for="user_id">User Login</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option 
                        value="{{ $user->id }}" 
                        data-nama="{{ $user->nama }}"
                        {{ $sopir->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->nama }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nama Sopir (otomatis dari user) -->
        <div class="form-group mb-3">
            <label for="nama">Nama Sopir</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $sopir->nama }}" readonly required>
        </div>

        <!-- No HP -->
        <div class="form-group mb-3">
            <label for="no_hp">No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $sopir->no_hp }}" required>
        </div>

        <!-- Alamat -->
        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2">{{ $sopir->alamat }}</textarea>
        </div>

        <!-- Status -->
        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ $sopir->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $sopir->status == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <!-- Dropdown Truk -->
        <div class="form-group mb-3">
            <label for="mastertruk_id">Truk</label>
            <select name="mastertruk_id" class="form-control" required>
                <option value="">-- Pilih Truk --</option>
                @foreach ($availableTruks as $truk)
                    <option value="{{ $truk->id }}" {{ $sopir->mastertruk_id == $truk->id ? 'selected' : '' }}>
                        {{ $truk->plat_nomor }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
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
