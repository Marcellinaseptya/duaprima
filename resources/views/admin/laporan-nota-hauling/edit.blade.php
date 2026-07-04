@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Edit Laporan Nota Hauling</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('nota-hauling.update', $nota->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Sopir</label>
            <input type="text" class="form-control" value="{{ $nota->sopir->nama }}" disabled>
        </div>

        <div class="form-group mt-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $nota->tanggal }}">
        </div>

        <div class="form-group mt-3">
            <label>Nota Hauling Saat Ini:</label><br>
            <a href="{{ Storage::url($nota->bukti_nota) }}" target="_blank">Lihat File</a>
        </div>
        <div class="form-group">
            <label for="bukti_nota">Ganti Nota (Opsional)</label>
            <input type="file" name="bukti_nota" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <div class="form-group mt-3">
            <label>Bukti Transfer Saat Ini:</label><br>
            @if ($nota->bukti_transfer)
                <a href="{{ Storage::url($nota->bukti_transfer) }}" target="_blank">Lihat Bukti Transfer</a>
            @else
                <span class="text-muted">Tidak ada</span>
            @endif
        </div>
        <div class="form-group">
            <label for="bukti_transfer">Ganti Bukti Transfer (Opsional)</label>
            <input type="file" name="bukti_transfer" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <div class="form-group mt-3">
            <label for="tarif_per_rit">Tarif per Ritase</label>
            <input type="number" name="tarif_per_rit" class="form-control" value="{{ $nota->tarif_per_rit }}">
        </div>

        <div class="form-group mt-3">
            <label for="jumlah_ritase">Jumlah Ritase</label>
            <input type="number" name="jumlah_ritase" class="form-control" value="{{ $nota->jumlah_ritase }}">
        </div>

        <div class="form-group mt-3">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ $nota->keterangan }}">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
        <a href="{{ route('admin.nota-hauling.index') }}" class="btn btn-secondary mt-4">Kembali</a>
    </form>
</div>
@endsection
