@extends('layout.main')

@section('content')
<div class="container">
    <h2>Tambah Transaksi Keuangan</h2>

    <form action="{{ route('transaksi-keuangan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sumber">Sumber</label>
            <input type="text" name="sumber" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nominal">Nominal</label>
            <input type="number" name="nominal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
