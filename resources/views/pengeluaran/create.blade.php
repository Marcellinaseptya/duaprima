@extends('layout.main')
@include('partials.sidebar-admin')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Tambah Pengeluaran</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Pengeluaran</h3>
                </div>

                <form action="{{ route('pengeluaran.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" id="tanggal" required>
                        </div>

                        <div class="form-group">
                            <label for="sumber">Sumber</label>
                            <input type="text" class="form-control" name="sumber" id="sumber" required>
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" name="nominal" class="form-control" id="nominal" placeholder="Masukkan nominal" required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" rows="3" placeholder="Masukkan keterangan"></textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('pengeluaran') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection
