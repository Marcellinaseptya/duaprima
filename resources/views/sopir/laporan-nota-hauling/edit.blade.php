@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Edit Laporan Nota Hauling')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Edit Laporan Nota Hauling</h4>

    {{-- Alert error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit --}}
    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('sopir.laporan-nota-hauling.update', $laporan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Tanggal <small class="text-danger">*</small></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $laporan->tanggal) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label>Tarif per Rit (Rp) <small class="text-danger">*</small></label>
                    <input type="number" name="tarif_per_rit" class="form-control" value="{{ old('tarif_per_rit', $laporan->tarif_per_rit) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label>Jumlah Ritase <small class="text-danger">*</small></label>
                    <input type="number" name="jumlah_ritase" class="form-control" value="{{ old('jumlah_ritase', $laporan->jumlah_ritase) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label>Nota Hauling (biarkan kosong jika tidak diubah)</label><br>
                    @if ($laporan->file_nota)
                        <a href="{{ Storage::url($laporan->file_nota) }}" target="_blank">Lihat File Saat Ini</a>
                    @endif
                    <input type="file" name="file_nota" class="form-control mt-2" accept=".jpg,.jpeg,.png,.pdf">
                </div>

                <div class="form-group mt-3">
                    <label>Bukti Transfer (biarkan kosong jika tidak diubah)</label><br>
                    @if ($laporan->bukti_transfer)
                        <a href="{{ Storage::url($laporan->bukti_transfer) }}" target="_blank">Lihat File Saat Ini</a>
                    @endif
                    <input type="file" name="bukti_transfer" class="form-control mt-2" accept=".jpg,.jpeg,.png,.pdf">
                </div>

                <div class="form-group mt-3">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $laporan->keterangan) }}">
                </div>

                <button type="submit" class="btn btn-success mt-3">Update</button>
                <a href="{{ route('sopir.laporan-nota-hauling.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
