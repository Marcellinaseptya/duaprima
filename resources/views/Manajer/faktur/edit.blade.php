@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Edit Faktur')

@section('content')
<div class="container mt-4">
    <h3>Edit Faktur</h3>
    <div class="card shadow-sm p-4 mt-3">
        <form action="{{ route('manajer.faktur.update', $faktur->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Klien</label>
                <select name="klien_id" class="form-control" required>
                    @foreach($kliens as $k)
                        <option value="{{ $k->id }}" {{ $faktur->klien_id == $k->id ? 'selected' : '' }}>{{ $k->nama_perusahaan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Kode Invoice</label>
                <input type="text" name="kode_invoice" class="form-control" value="{{ $faktur->kode_invoice }}" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Invoice</label>
                <input type="date" name="tanggal_invoice" class="form-control" value="{{ $faktur->tanggal_invoice }}" required>
            </div>
            <div class="mb-3">
                <label>Total Tagihan</label>
                <input type="text" name="total_tagihan" class="form-control rupiah-input" value="{{ $faktur->total_tagihan }}" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="belum_bayar" {{ $faktur->status == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="dp" {{ $faktur->status == 'dp' ? 'selected' : '' }}>DP</option>
                    <option value="sudah_bayar" {{ $faktur->status == 'sudah_bayar' ? 'selected' : '' }}>Lunas (Sudah Bayar)</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ $faktur->keterangan }}</textarea>
            </div>
            <button class="btn btn-primary">Update Faktur</button>
            <a href="{{ route('manajer.faktur.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
