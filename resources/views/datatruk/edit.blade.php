@extends('layout.main')
@include('partials.sidebar-admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Edit Truk</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <a href="{{ route('mastertruk.index') }}" class="btn btn-secondary mb-3">Kembali</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Truk</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('mastertruk.update', $mastertruk->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="plat_nomor">Plat Nomor</label>
                        <input type="text" name="plat_nomor" class="form-control" value="{{ old('plat_nomor', $mastertruk->plat_nomor) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Truk</label>
                        <input type="text" name="jenis" class="form-control" value="{{ old('jenis', $mastertruk->jenis) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection