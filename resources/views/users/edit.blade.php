@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Edit Pengguna</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Edit Pengguna</h3>
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {{-- TAMBAHKAN KODE INI UNTUK MENAMPILKAN ERROR VALIDASI --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- AKHIR KODE ERROR --}}

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manajer" {{ $user->role == 'manajer' ? 'selected' : '' }}>Manajer</option>
                            <option value="sopir" {{ $user->role == 'sopir' ? 'selected' : '' }}>Sopir</option>
                            <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kata Sandi (biarkan kosong jika tidak ingin mengubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>

                <div class="card-footer">
                    {{-- PERBAIKAN: Ubah 'users' menjadi 'users.index' --}}
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection