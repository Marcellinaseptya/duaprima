@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Tambah Faktur')

@section('content')
<div class="container mt-4">
    <h3>Tambah Faktur Baru</h3>
    <div class="card shadow-sm p-4 mt-3">
        <form action="{{ route('manajer.faktur.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Klien</label>
                <select name="klien_id" class="form-control" required>
                    <option value="">-- Pilih Klien --</option>
                    @foreach($kliens as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_perusahaan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Kode Invoice</label>
                <input type="text" name="kode_invoice" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Invoice</label>
                <input type="date" name="tanggal_invoice" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Total Tagihan</label>
                <input type="text" name="total_tagihan" class="form-control rupiah-input" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="belum_bayar">Belum Bayar</option>
                    <option value="dp">DP</option>
                    <option value="sudah_bayar">Lunas (Sudah Bayar)</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Simpan Faktur</button>
            <a href="{{ route('manajer.faktur.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
