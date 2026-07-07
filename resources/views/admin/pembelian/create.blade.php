@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Tambah Pembelian Sparepart')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Input Pembelian Sparepart</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-shopping-cart mr-2"></i> Detail Transaksi Baru</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.pembelian.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Pilih Sparepart <span class="text-danger">*</span></label>
                                    <select name="sparepart_id" id="sparepart_id" class="form-control select2" required>
                                        <option value="">-- Cari Sparepart --</option>
                                        @foreach ($spareparts as $sparepart)
                                            <option value="{{ $sparepart->id }}">{{ $sparepart->nama_sparepart }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jumlah <span class="text-danger">*</span></label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" placeholder="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Satuan <span class="text-danger">*</span></label>
                                            <select name="satuan" class="form-control" required>
                                                <option value="pcs">Pcs</option>
                                                <option value="liter">Liter</option>
                                                <option value="unit">Unit</option>
                                                <option value="set">Set</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light">Rp</span>
                                        </div>
                                        <input type="text" name="harga_satuan" id="harga_satuan" class="form-control rupiah-input" placeholder="0" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Supplier</label>
                                    <input list="supplierList" name="supplier" class="form-control" placeholder="Ketik nama supplier...">
                                    <datalist id="supplierList">
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier }}">
                                        @endforeach
                                    </datalist>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Pembelian <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pembelian" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold text-success">Total Bayar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-success text-white">Rp</span>
                                        </div>
                                        <input type="text" id="harga_total_display" class="form-control form-control-lg font-weight-bold text-success" readonly value="0">
                                        <input type="hidden" name="harga_total" id="harga_total">
                                    </div>
                                </div>
                            </div>

                            {{-- Full Width --}}
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">Catatan Tambahan</label>
                                    <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Pembelian untuk truk plat B 1234 XX"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Upload Nota <small class="text-muted">(Opsional: jpg, png, pdf)</small></label>
                                    <div class="custom-file">
                                        <input type="file" name="nota" class="custom-file-input" id="nota" accept=".jpg,.jpeg,.png,.pdf">
                                        <label class="custom-file-label" for="nota">Pilih file...</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm font-weight-bold">
                                <i class="fas fa-save mr-2"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Hitung Total & File Name --}}
<script>
    const jumlah = document.getElementById('jumlah');
    const hargaSatuan = document.getElementById('harga_satuan');
    const hargaTotalDisplay = document.getElementById('harga_total_display');
    const hargaTotal = document.getElementById('harga_total');
    const fileInput = document.getElementById('nota');

    function hitungTotal() {
        const j = parseFloat(jumlah.value) || 0;
        const h = parseFloat(hargaSatuan.value.replace(/\./g, '')) || 0;
        const total = j * h;

        // Tampilan format ribuan
        hargaTotalDisplay.value = new Intl.NumberFormat('id-ID').format(total);
        hargaTotal.value = total;
    }

    jumlah.addEventListener('input', hitungTotal);
    hargaSatuan.addEventListener('input', hitungTotal);

    // Menampilkan nama file di custom-file-input
    fileInput.addEventListener('change', function(e){
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endsection