@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Edit Data Truk</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Edit Truk</h3>
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

            <form action="{{ route('truk.update', $truk->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">

                    {{-- Tanggal --}}
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal', $truk->tanggal) }}">
                    </div>

                    {{-- Plat Nomor Truk --}}
                    <div class="form-group">
                        <label>Plat Nomor Truk</label>
                        <select name="mastertruk_id" class="form-control" required>
                            @foreach($mastertruks as $dt)
                                <option value="{{ $dt->id }}" {{ old('mastertruk_id', $truk->mastertruk_id) == $dt->id ? 'selected' : '' }}>
                                    {{ $dt->plat_nomor }} ({{ $dt->jenis }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sopir --}}
                    <div class="form-group">
                        <label>Nama Sopir</label>
                        <select name="sopir_id" class="form-control" required>
                            @foreach($sopirs as $sp)
                                <option value="{{ $sp->id }}" {{ old('sopir_id', $truk->sopir_id) == $sp->id ? 'selected' : '' }}>
                                    {{ $sp->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Perusahaan --}}
                    <div class="form-group">
                        <label>Perusahaan</label>
                        <input type="text" name="perusahaan" class="form-control" required value="{{ old('perusahaan', $truk->perusahaan) }}">
                    </div>

                    {{-- Tarif --}}
                    <div class="form-group">
                        <label>Tarif</label>
                        <input type="text" id="tarif_display" class="form-control" value="{{ 'Rp ' . number_format(old('tarif', $truk->tarif), 0, ',', '.') }}" required>
                        <input type="hidden" name="tarif" id="tarif" value="{{ old('tarif', $truk->tarif) }}">
                    </div>

                    {{-- BBM --}}
                    <div class="form-group">
                        <label>BBM</label>
                        <input type="text" id="bbm_display" class="form-control" value="{{ 'Rp ' . number_format(old('bbm', $truk->bbm), 0, ',', '.') }}" required>
                        <input type="hidden" name="bbm" id="bbm" value="{{ old('bbm', $truk->bbm) }}">
                    </div>

                    {{-- Netto --}}
                    <div class="form-group">
                        <label>Netto (Kg)</label>
                        <input type="text" name="netto" id="netto" class="form-control" value="{{ old('netto', $truk->netto) }}">
                    </div>

                    {{-- Keuntungan Sopir --}}
                    <div class="form-group">
                        <label>Keuntungan Sopir (25%)</label>
                        <input type="text" name="keuntungan_sopir" id="keuntungan_sopir" class="form-control" value="{{ old('keuntungan_sopir', $truk->keuntungan_sopir) }}" readonly>
                    </div>

                    {{-- Keuntungan Perusahaan --}}
                    <div class="form-group">
                        <label>Keuntungan Perusahaan (75%)</label>
                        <input type="text" name="keuntungan_perusahaan" id="keuntungan_perusahaan" class="form-control" value="{{ old('keuntungan_perusahaan', $truk->keuntungan_perusahaan) }}" readonly>
                    </div>

                    {{-- Keterangan --}}
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" readonly>{{ old('keterangan', $truk->keterangan) }}</textarea>
                    </div>

                    {{-- Tombol Hitung --}}
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

<script>
function formatRupiah(angka, prefix = '') {
    let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    return prefix + rupiah;
}

function syncInput(displayId, hiddenId) {
    const displayInput = document.getElementById(displayId);
    const hiddenInput = document.getElementById(hiddenId);

    displayInput.addEventListener('input', function () {
        const numeric = this.value.replace(/[^0-9]/g, '');
        hiddenInput.value = numeric;
        this.value = formatRupiah(numeric, 'Rp ');
    });
}

syncInput('tarif_display', 'tarif');
syncInput('bbm_display', 'bbm');

function hitung() {
    const netto = parseFloat(document.getElementById('netto').value.replace(/\./g, '').replace(',', '.')) || 0;
    const tarif = parseFloat(document.getElementById('tarif').value) || 0;
    const bbm = parseFloat(document.getElementById('bbm').value) || 0;

    const keuntunganBersih = tarif - bbm;
    const keuntunganSopir = keuntunganBersih * 0.25;
    const keuntunganPerusahaan = keuntunganBersih * 0.75;

    let bonusSopir = 0;
    let keterangan = "";

    if (netto > 11500) {
        bonusSopir = 60000;
        keterangan = "Sopir mendapat bonus Rp 60.000 karena muatan melebihi 11.500 Kg.";
    } else {
        keterangan = "Sopir tidak mendapat bonus karena muatan kurang dari atau sama dengan 11.500 Kg.";
    }

    document.getElementById('keuntungan_sopir').value = formatRupiah(Math.round(keuntunganSopir + bonusSopir).toString(), 'Rp ');
    document.getElementById('keuntungan_perusahaan').value = formatRupiah(Math.round(keuntunganPerusahaan).toString(), 'Rp ');
    document.getElementById('keterangan').value = keterangan;
}
</script>
@endsection