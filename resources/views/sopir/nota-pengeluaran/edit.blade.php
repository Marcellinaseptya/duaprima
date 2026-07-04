@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Edit Nota')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Edit Nota Pengeluaran</h4>

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

    {{-- Form Edit --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('sopir.nota-pengeluaran.update', $nota->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Pilih jenis nota --}}
                <div class="form-group">
                    <label for="jenis">Jenis Nota <small class="text-danger">*</small></label>
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="hauling" {{ $nota->jenis == 'hauling' ? 'selected' : '' }}>Perjalanan</option>
                        <option value="bbm" {{ $nota->jenis == 'bbm' ? 'selected' : '' }}>BBM</option>
                        <option value="perbaikan" {{ $nota->jenis == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                        <option value="lainnya" {{ $nota->jenis == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Ganti file nota --}}
                <div class="form-group mt-3">
                    <label for="file_nota">Ganti File Nota <small class="text-muted">(Opsional)</small></label>
                    <input type="file" name="file_nota" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    <small class="form-text text-muted">
                        Biarkan kosong jika tidak ingin mengganti file. Saat ini file:
                        <a href="{{ Storage::url($nota->file_nota) }}" target="_blank">Lihat File Lama</a>
                    </small>
                </div>

                {{-- Keterangan --}}
                <div class="form-group mt-3">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="{{ $nota->keterangan }}" placeholder="Contoh: Isi BBM di SPBU A">
                </div>

                {{-- Tanggal (jika ingin update tanggal) --}}
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal <small class="text-danger">*</small></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $nota->tanggal->format('Y-m-d') }}" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                <a href="{{ route('sopir.nota-pengeluaran.index') }}" class="btn btn-secondary mt-3">Batal</a>
            </form>
        </div>
    </div>

    {{-- Info tambahan --}}
    <div class="alert alert-info">
        <strong>Tips:</strong>
        <ul class="mb-0">
            <li>Jika kamu mengunggah file baru, file lama akan otomatis diganti.</li>
            <li>Pastikan format file sesuai: JPG, PNG, atau PDF dan ukuran maksimal 2MB.</li>
            <li>Jika tidak ingin mengganti file, biarkan input file kosong.</li>
        </ul>
    </div>
</div>
@endsection
