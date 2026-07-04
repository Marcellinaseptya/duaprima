@extends('layout.main')
@include('partials.sidebar-admin')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Tambah Perbaikan Truk</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Perbaikan</h3>
                </div>

                <form action="{{ route('perbaikan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sopir_id">Nama Sopir</label>
                            <select name="sopir_id" id="sopir_id" class="form-control" required>
                                <option value="">-- Pilih Sopir --</option>
                                @foreach ($sopirs as $sopir)
                                    <option value="{{ $sopir->id }}">{{ $sopir->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mastertruk_id">Plat Nomor Truk</label>
                            <select name="mastertruk_id" id="mastertruk_id" class="form-control" required>
                                <option value="">-- Pilih Truk --</option>
                                @foreach ($truks as $truk)
                                    <option value="{{ $truk->id }}">{{ $truk->plat_nomor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keluhan">Keluhan / Jenis Kerusakan</label>
                            <textarea name="keluhan" id="keluhan" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status Perbaikan</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Menunggu Suku Cadang">Menunggu Suku Cadang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
                            <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto Kerusakan (opsional)</label>
                            <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('perbaikan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
