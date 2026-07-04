@extends('layout.main')
@include('partials.sidebar-admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Tambah Truk</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <a href="{{ route('mastertruk.index') }}" class="btn btn-secondary mb-3">Kembali</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Truk</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('mastertruk.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="plat_nomor">Plat Nomor</label>
                        <input type="text" name="plat_nomor" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Truk</label>
                        <input type="text" name="jenis" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</section>
</div>
@endsection