@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Laporan Nota Hauling')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Laporan Nota Hauling</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- FILTER --}}
        <form method="GET" action="{{ route('admin.laporan-nota-hauling.index') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label class="mr-1">Dari</label>
                <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
            </div>
            <div class="form-group mr-2">
                <label class="mr-1">Sampai</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
            </div>
            <button type="submit" class="btn btn-primary mr-2">Filter</button>
            <a href="{{ route('admin.laporan-nota-hauling.export', request()->all()) }}" target="_blank" class="btn btn-success">Export PDF</a>
        </form>

        {{-- TABEL --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Nota Hauling</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Sopir</th>
                            <th>Tarif / Rit</th>
                            <th>Jumlah Ritase</th>
                            <th>Total</th>
                            <th>Nota</th>
                            <th>Bukti Transfer</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notas as $nota)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $nota->sopir->nama ?? '-' }}</td>
                            <td>Rp{{ number_format($nota->tarif_per_rit, 0, ',', '.') }}</td>
                            <td>{{ $nota->jumlah_ritase }}</td>
                            <td>Rp{{ number_format($nota->tarif_per_rit * $nota->jumlah_ritase, 0, ',', '.') }}</td>
                            <td>
                                @if ($nota->file_nota)
                                    <a href="{{ Storage::url($nota->file_nota) }}" target="_blank">Lihat Nota</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($nota->bukti_transfer)
                                    <a href="{{ Storage::url($nota->bukti_transfer) }}" target="_blank">Lihat Bukti</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $nota->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data nota hauling</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection