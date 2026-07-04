@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Edit Klien')

@section('content')
<div class="container mt-4">
    <h1>Edit Klien</h1>

    <form action="{{ route('admin.klien.update', $klien->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', $klien->nama_perusahaan) }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $klien->alamat) }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $klien->no_hp) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $klien->email) }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ old('status', $klien->status)=='aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $klien->status)=='nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $klien->keterangan) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.klien.index') }}" class="btn btn-secondary">Batal</a>
    </form>

    <hr>

    <h4>Riwayat Status</h4>
    <ul>
        @forelse($klien->riwayatStatus as $r)
            <li>
                {{ $r->status }}: {{ \Carbon\Carbon::parse($r->mulai)->format('d-m-Y') }}
                @if($r->selesai) s/d {{ \Carbon\Carbon::parse($r->selesai)->format('d-m-Y') }} @endif
            </li>
        @empty
            <li>Belum ada riwayat status.</li>
        @endforelse
    </ul>
</div>
@endsection
