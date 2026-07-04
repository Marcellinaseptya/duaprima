@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Tambah Laporan Nota Hauling')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Tambah Laporan Nota Hauling</h4>

    {{-- Alert validasi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('sopir.laporan-nota-hauling.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Tanggal <small class="text-danger">*</small></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                </div>

                <div class="form-group mt-3">
                    <label>Tarif per Rit (Rp) <small class="text-danger">*</small></label>
                    <input type="number" name="tarif_per_rit" class="form-control" value="{{ old('tarif_per_rit') }}" required>
                </div>

                <div class="form-group mt-3">
                    <label>Jumlah Ritase <small class="text-danger">*</small></label>
                    <input type="number" name="jumlah_ritase" class="form-control" value="{{ old('jumlah_ritase') }}" required>
                </div>

                <div class="form-group mt-3">
                    <label>Upload Nota Hauling <small class="text-danger">*</small></label>
                    <input type="file" name="file_nota" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>

                <div class="form-group mt-3">
                    <label>Upload Bukti Transfer <small class="text-danger">*</small></label>
                    <input type="file" name="bukti_transfer" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>

                <div class="form-group mt-3">
                    <label>Keterangan (opsional)</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Ditransfer pagi ini oleh Owner A">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Kirim Laporan</button>
                <a href="{{ route('sopir.laporan-nota-hauling.index') }}" class="btn btn-secondary mt-3">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
