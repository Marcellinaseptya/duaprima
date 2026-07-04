@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Edit Peminjaman</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Peminjaman</h3>
                </div>

                <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ $peminjaman->tanggal }}" required>
                        </div>

                        <div class="form-group">
                            <label for="sumber">Sumber</label>
                            <input type="text" class="form-control" name="sumber" value="{{ $peminjaman->sumber }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" class="form-control" name="nominal" value="{{ $peminjaman->nominal }}" required>
                        </div>

                        <div class="form-group">
                            <label for="terbayar">Terbayar</label>
                            <input type="number" class="form-control" name="terbayar" value="{{ $peminjaman->terbayar }}" required>
                        </div>

                        <div class="form-group">
                            <label for="status_pelunasan">Status Pelunasan</label>
                            <select name="status_pelunasan" class="form-control" required>
                                <option value="BELUM LUNAS" {{ $peminjaman->status_pelunasan == 'BELUM LUNAS' ? 'selected' : '' }}>BELUM LUNAS</option>
                                <option value="LUNAS" {{ $peminjaman->status_pelunasan == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan">{{ $peminjaman->keterangan }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="sopir_id">Sopir</label>
                            <select name="sopir_id" class="form-control" required>
                                <option value="">-- Pilih Sopir --</option>
                                @foreach ($sopirs as $sopir)
                                    <option value="{{ $sopir->id }}" {{ $peminjaman->sopir_id == $sopir->id ? 'selected' : '' }}>
                                        {{ $sopir->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ route('peminjaman') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
@endsection