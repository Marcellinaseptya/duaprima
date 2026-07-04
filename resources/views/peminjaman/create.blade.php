@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Tambah Peminjaman</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Peminjaman</h3>
                </div>

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>

                        <div class="form-group">
                            <label for="sumber">Sumber</label>
                            <input type="text" class="form-control" name="sumber" required>
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" class="form-control" name="nominal" required>
                        </div>

                        <div class="form-group">
                            <label for="terbayar">Terbayar</label>
                            <input type="number" class="form-control" name="terbayar" value="0" required>
                        </div>

                        <div class="form-group">
                            <label for="status_pelunasan">Status Pelunasan</label>
                            <select name="status_pelunasan" class="form-control" required>
                                <option value="BELUM LUNAS">BELUM LUNAS</option>
                                <option value="LUNAS">LUNAS</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="sopir_id">Sopir</label>
                            <select name="sopir_id" class="form-control" required>
                                <option value="">-- Pilih Sopir --</option>
                                @foreach ($sopirs as $sopir)
                                    <option value="{{ $sopir->id }}">{{ $sopir->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('peminjaman') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
@endsection