@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Edit Pembelian Sparepart')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Riwayat Pembelian</h1>
        <a href="{{ route('admin.pembelian.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <ul class="mb-0 font-weight-bold">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-edit mr-2"></i> Ubah Data Transaksi</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.pembelian.update', $pembelian->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
    <label class="font-weight-bold">Pilih Sparepart <span class="text-danger">*</span></label>
    <select name="sparepart_id" class="form-control @error('sparepart_id') is-invalid @enderror" required>
        <option value="">-- Pilih Sparepart --</option>
        @foreach($spareparts as $sp)
            <option value="{{ $sp->id }}" {{ old('sparepart_id', $pembelian->sparepart_id) == $sp->id ? 'selected' : '' }}>
                {{ $sp->nama_sparepart }}
            </option>
        @endforeach
    </select>
    @error('sparepart_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>                         <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Harga Satuan <span class="text-danger">*</span></label>
                                            <input type="number" name="harga_satuan" id="harga_satuan" class="form-control" 
                                                   value="{{ old('harga_satuan', $pembelian->harga_satuan) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Satuan <span class="text-danger">*</span></label>
                                            <input type="text" name="satuan" class="form-control" 
                                                   value="{{ old('satuan', $pembelian->satuan) }}" placeholder="Pcs/Set" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jumlah <span class="text-danger">*</span></label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" 
                                                   value="{{ old('jumlah', $pembelian->jumlah) }}" min="1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-success">Total Harga (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="harga_total" id="harga_total" class="form-control font-weight-bold" 
                                                   value="{{ old('harga_total', $pembelian->harga_total) }}" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Supplier</label>
                                    <input type="text" name="supplier" class="form-control" 
                                           value="{{ old('supplier', $pembelian->supplier) }}" placeholder="Nama Toko/Supplier">
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Pembelian <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pembelian" class="form-control" 
                                           value="{{ old('tanggal_pembelian', $pembelian->tanggal_pembelian) }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $pembelian->catatan) }}</textarea>
                                </div>
                            </div>

                            {{-- Section Nota --}}
                            <div class="col-12 mt-3">
                                <div class="form-group border-top pt-3">
                                    <label class="font-weight-bold">Update Nota <small class="text-muted">(Opsional)</small></label>
                                    @if($pembelian->nota)
                                        <div class="mb-2 small text-muted">Nota Saat Ini: <a href="{{ asset('storage/' . $pembelian->nota) }}" target="_blank">Lihat File</a></div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" name="nota" class="custom-file-input" id="nota" accept=".jpg,.jpeg,.png,.pdf">
                                        <label class="custom-file-label" for="nota">Pilih file baru...</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning px-5 shadow-sm font-weight-bold">
                                <i class="fas fa-sync-alt mr-2"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Kalkulasi Otomatis Harga Total
    const hargaSatuan = document.getElementById('harga_satuan');
    const jumlah = document.getElementById('jumlah');
    const hargaTotal = document.getElementById('harga_total');

    function hitungTotal() {
        const total = (hargaSatuan.value || 0) * (jumlah.value || 0);
        hargaTotal.value = total;
    }

    hargaSatuan.addEventListener('input', hitungTotal);
    jumlah.addEventListener('input', hitungTotal);

    // Label File
    document.getElementById('nota').addEventListener('change', function(e){
        var fileName = e.target.files[0].name;
        e.target.nextElementSibling.innerText = fileName;
    });
</script>
@endsections