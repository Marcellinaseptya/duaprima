@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Tambah Nota Pengeluaran')

@section('content')
<div class="container mt-4">
    <h4>Tambah Nota Pengeluaran</h4>

    {{-- Form tambah nota --}}
    <form action="{{ route('admin.nota-pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Sopir</label>
            <select name="sopir_id" class="form-control" required>
                <option value="">-- Pilih Sopir --</option>
                @foreach($sopirs as $sopir)
                    <option value="{{ $sopir->id }}">{{ $sopir->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jenis Nota</label>
            <input type="text" name="jenis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>File Bukti</label>
            <input type="file" name="file_bukti" class="form-control" accept=".jpg,.png,.pdf" required>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.nota-pengeluaran.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection
