@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Edit Data Sparepart')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Edit Data Sparepart</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.sparepart.update', $sparepart->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label>Nama Sparepart</label>
                    <input type="text" name="nama_sparepart" class="form-control @error('nama_sparepart') is-invalid @enderror"
                        value="{{ old('nama_sparepart', $sparepart->nama_sparepart) }}" required>
                    @error('nama_sparepart') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                        value="{{ old('stok', $sparepart->stok) }}" min="0" required>
                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Satuan</label>
                    <input type="text" name="satuan" class="form-control @error('satuan') is-invalid @enderror"
                        value="{{ old('satuan', $sparepart->satuan) }}" required>
                    @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Harga Satuan</label>
                    <input type="number" name="harga_satuan" class="form-control @error('harga_satuan') is-invalid @enderror"
                        value="{{ old('harga_satuan', $sparepart->harga_satuan) }}" min="0" required>
                    @error('harga_satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('admin.sparepart.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
