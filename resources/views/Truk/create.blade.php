@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Tambah Data Truk</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Truk</h3>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('truk.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Plat Nomor Truk</label>
                        <select name="mastertruk_id" class="form-control" required>
                            <option value="">-- Pilih Plat Nomor --</option>
                            @foreach($mastertruks as $mastertruk)
                                <option value="{{ $mastertruk->id }}" {{ old('mastertruk_id') == $mastertruk->id ? 'selected' : '' }}>
                                    {{ $mastertruk->plat_nomor }} ({{ $mastertruk->jenis }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Sopir</label>
                        <select name="sopir_id" class="form-control" required>
                            <option value="">-- Pilih Sopir --</option>
                            @foreach($sopirs as $sopir)
                                <option value="{{ $sopir->id }}" {{ old('sopir_id') == $sopir->id ? 'selected' : '' }}>
                                    {{ $sopir->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Perusahaan</label>
                        <input type="text" name="perusahaan" class="form-control" value="{{ old('perusahaan') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Tarif</label>
                        <input type="text" id="tarif_display" class="form-control" value="{{ old('tarif') }}" required>
                        <input type="hidden" name="tarif" id="tarif">
                    </div>

                    <div class="form-group">
                        <label>BBM</label>
                        <input type="text" id="bbm_display" class="form-control" value="{{ old('bbm') }}" required>
                        <input type="hidden" name="bbm" id="bbm">
                    </div>

                    <div class="form-group">
                        <label>Netto (Kg)</label>
                        <input type="text" id="netto_display" class="form-control" value="{{ old('netto') }}" required>
                        <input type="hidden" name="netto" id="netto">
                    </div>

                    <div class="form-group">
                        <label>Keuntungan Sopir</label>
                        <input type="text" name="keuntungan_sopir" id="keuntungan_sopir" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Keuntungan Perusahaan</label>
                        <input type="text" name="keuntungan_perusahaan" id="keuntungan_perusahaan" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" readonly>{{ old('keterangan') }}</textarea>
                    </div>

                    <button type="button" class="btn btn-info mb-3" onclick="hitung()">Hitung Otomatis</button>

                </div>

                <div class="card-footer">
                    <a href="{{ route('truk') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

{{-- Script Hitung --}}
<script>
function hitung() {
    const tarif = parseInt(document.getElementById("tarif_display").value.replace(/\D/g, "")) || 0;
    const bbm = parseInt(document.getElementById("bbm_display").value.replace(/\D/g, "")) || 0;
    const netto = parseInt(document.getElementById("netto_display").value.replace(/\D/g, "")) || 0;

    const hargaBersih = tarif - bbm;
    const bonus = netto > 11500 ? 60000 : 0;

    const keuntunganSopir = hargaBersih * 0.25 + bonus;
    const keuntunganPerusahaan = hargaBersih * 0.75;

    // Update input hidden
    document.getElementById("tarif").value = tarif;
    document.getElementById("bbm").value = bbm;
    document.getElementById("netto").value = netto;

    // Update hasil perhitungan
    document.getElementById("keuntungan_sopir").value = "Rp" + keuntunganSopir.toLocaleString('id-ID');
    document.getElementById("keuntungan_perusahaan").value = "Rp" + keuntunganPerusahaan.toLocaleString('id-ID');

    document.getElementById("keterangan").value = bonus > 0
        ? 'Sopir mendapat bonus Rp 60.000 karena muatan melebihi 11.500 Kg.'
        : 'Sopir tidak mendapat bonus karena muatan kurang dari atau sama dengan 11.500 Kg.';
}
</script>