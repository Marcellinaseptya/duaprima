@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Edit Maintenance')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Edit Data Maintenance</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('manajer.maintenance.update', $maintenance->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="mb-3">
                    <label for="mastertruk_id" class="form-label">Truk <span class="text-danger">*</span></label>
                    <select name="mastertruk_id" id="mastertruk_id" class="form-select @error('mastertruk_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Truk --</option>
                        @foreach($mastertruk as $truk)
                            <option value="{{ $truk->id }}" {{ $maintenance->mastertruk_id == $truk->id ? 'selected' : '' }}>
                                {{ $truk->plat_nomor ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_perbaikan" class="form-label">Tanggal Perbaikan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan" class="form-control @error('tanggal_perbaikan') is-invalid @enderror" value="{{ old('tanggal_perbaikan', $maintenance->tanggal_perbaikan) }}" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi_perbaikan" class="form-label">Deskripsi Perbaikan <span class="text-danger">*</span></label>
                    <textarea name="deskripsi_perbaikan" id="deskripsi_perbaikan" class="form-control @error('deskripsi_perbaikan') is-invalid @enderror" rows="3" required>{{ old('deskripsi_perbaikan', $maintenance->deskripsi_perbaikan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="biaya" class="form-label">Biaya <span class="text-danger">*</span></label>
                    <input type="text" name="biaya" id="biaya" class="form-control rupiah-input @error('biaya') is-invalid @enderror" value="{{ old('biaya', $maintenance->biaya) }}" required>
                </div>

                <div class="mb-3">
                    <label for="foto_bukti" class="form-label">Foto / Bukti (Opsional)</label>
                    <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                    @if($maintenance->foto_bukti)
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $maintenance->foto_bukti) }}" target="_blank">Lihat</a></small>
                    @endif
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('manajer.maintenance.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
