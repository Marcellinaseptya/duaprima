@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Tambah Pengguna</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Pengguna</h3>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="manajer">Manajer</option>
                            <option value="sopir">Sopir</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="card-footer">
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-success">Simpan</button>
</div>
            </form>
        </div>
    </div>
</section>
@endsection
