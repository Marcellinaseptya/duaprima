@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')

<div class="content-header">  
    <div class="container-fluid">  
        <h1 class="m-0">Data Truk</h1>  
    </div>  
</div>  

{{-- FILTER --}}
<form method="GET" action="{{ route('truk') }}" class="form-inline mb-3">  
    <input type="date" name="tanggal" class="form-control mr-2" value="{{ request('tanggal') }}">
    
    <select name="sopir_id" class="form-control mr-2">  
        <option value="">-- Pilih Sopir --</option>  
        @foreach($sopirs as $sopir)  
            <option value="{{ $sopir->id }}" {{ request('sopir_id') == $sopir->id ? 'selected' : '' }}>
                {{ $sopir->nama }}  
            </option>  
        @endforeach  
    </select>  

    <select name="perusahaan" class="form-control mr-2">  
        <option value="">-- Pilih Perusahaan --</option>  
        @foreach($perusahaans as $perusahaan)  
            <option value="{{ $perusahaan }}" {{ request('perusahaan') == $perusahaan ? 'selected' : '' }}>
                {{ $perusahaan }}  
            </option>  
        @endforeach  
    </select>  

    <button type="submit" class="btn btn-primary mr-2">Filter</button>
    <a href="{{ route('truk.export.pdf', request()->query()) }}" class="btn btn-danger mb-3 ml-2" target="_blank">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>
</form>  

<section class="content">  
    <div class="container-fluid">  
        <div class="row">  
            <div class="col-12">  
                <a href="{{ route('truk.create') }}" class="btn btn-primary mb-3">Tambah Truk</a>  

                <div class="card">  
                    <div class="card-header">  
                        <h3 class="card-title">Data Truk</h3>  
                    </div>  

                    <div class="card-body table-responsive p-0">  
                        <table class="table table-hover text-nowrap">  
                            <thead>  
                                <tr>  
                                    <th>No</th>  
                                    <th>Tanggal</th>  
                                    <th>Sopir</th>  
                                    <th>Perusahaan</th>  
                                    <th>Plat Nomor</th>  
                                    <th>Tarif</th>  
                                    <th>BBM</th>  
                                    <th>Netto</th>  
                                    <th>Harga Bersih</th> {{-- Baru --}}
                                    <th>Keuntungan Sopir</th>  
                                    <th>Keuntungan Perusahaan</th>  
                                    <th>Keterangan</th>  
                                    <th>Action</th>  
                                </tr>  
                            </thead>  
                            <tbody>  
                                @forelse ($truks as $truk)  
                                <tr>  
                                    <td>{{ $loop->iteration }}</td>  
                                    <td>{{ \Carbon\Carbon::parse($truk->tanggal)->format('d-m-Y') }}</td>  
                                    <td>{{ $truk->sopir->nama ?? '-' }}</td>  
                                    <td>{{ $truk->perusahaan }}</td>  
                                    <td>{{ $truk->mastertruk->plat_nomor ?? '-' }}</td>  
                                    <td>Rp{{ number_format($truk->tarif, 0, ',', '.') }}</td>  
                                    <td>Rp{{ number_format($truk->bbm, 0, ',', '.') }}</td>  
                                    <td>{{ number_format($truk->netto, 0, ',', '.') }} Kg</td>  
                                    <td>Rp{{ number_format($truk->netto * $truk->tarif, 0, ',', '.') }}</td> {{-- Harga Bersih --}}
                                    <td>Rp{{ number_format($truk->keuntungan_sopir, 0, ',', '.') }}</td>  
                                    <td>Rp{{ number_format($truk->keuntungan_perusahaan, 0, ',', '.') }}</td>  
                                    <td>{{ $truk->keterangan }}</td>  
                                    <td>  
                                        <a href="{{ route('truk.edit', $truk->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>  
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-{{ $truk->id }}">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>  
                                    </td>  
                                </tr>  
                                @empty  
                                <tr>  
                                    <td colspan="13" class="text-center">Tidak ada data truk.</td>  
                                </tr>  
                                @endforelse  
                            </tbody>  
                        </table>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
</section>  

{{-- MODAL HAPUS --}}
@foreach ($truks as $truk)
<div class="modal fade" id="modal-hapus-{{ $truk->id }}" tabindex="-1" role="dialog">  
    <div class="modal-dialog" role="document">  
        <div class="modal-content">  
            <div class="modal-header">  
                <h5 class="modal-title">Konfirmasi Hapus</h5>  
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>  
            </div>  
            <div class="modal-body">  
                <p>Yakin ingin menghapus data truk milik <strong>{{ $truk->sopir->nama ?? '-' }}</strong>?</p>  
            </div>  
            <div class="modal-footer justify-content-between">  
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>  
                <form action="{{ route('truk.destroy', $truk->id) }}" method="POST">  
                    @csrf  
                    @method('DELETE')  
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>  
                </form>  
            </div>  
        </div>  
    </div>  
</div>  
@endforeach  

@endsection