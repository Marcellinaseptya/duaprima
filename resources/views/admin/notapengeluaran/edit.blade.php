@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Edit Nota Pengeluaran')

@section('content')
<div class="container mt-4">
    <h4>Edit Nota Pengeluaran</h4>

    <form action="{{ route('admin.nota-pengeluaran.update', $nota->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Sopir</label>
            <select name="sopir_id" class="form-control" required>
                <option value="">-- Pilih Sopir --</option>
                @foreach($sopirs as $sopir)
                    <option value="{{ $sopir->id }}" {{ $nota->sopir_id == $sopir->id ? 'selected' : '' }}>
                        {{ $sopir->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jenis Nota</label>
            <input type="text" name="jenis" class="form-control" value="{{ $nota->jenis }}" required>
        </div>

        <div class="mb-3">
            <label>File Bukti</label>
            <input type="file" name="file_bukti" class="form-control" accept=".jpg,.png,.pdf">
            @if($nota->file_bukti)
                <p class="mt-2">
                    File saat ini: <a href="{{ Storage::url($nota->file_bukti) }}" target="_blank">Lihat File</a>
                </p>
            @endif
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $nota->tanggal->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ $nota->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.nota-pengeluaran.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection
