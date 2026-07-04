@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Tambah Ritase')

@section('content')
<div class="container mt-4">
    <h4>Tambah Data Ritase</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sopir.ritase.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="jadwal_operasional_id">Pilih Jadwal</label>
            <select name="jadwal_operasional_id" id="jadwal_operasional_id" class="form-control" required>
                <option value="">-- Pilih Jadwal --</option>
                @foreach ($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}">
                        {{ $jadwal->tanggal }} - {{ $jadwal->truk->plat_nomor ?? 'Tanpa Truk' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Ritase</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jumlah_rit">Jumlah Rit</label>
            <input type="number" name="jumlah_rit" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="tarif_per_rit">Tarif per Rit</label>
            <input type="number" name="tarif_per_rit" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="bukti_transfer">Bukti Transfer dari Owner (Opsional)</label>
            <input type="file" name="bukti_transfer" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('sopir.ritase.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
