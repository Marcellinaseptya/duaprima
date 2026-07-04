@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Laporan Nota Hauling</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.laporan-notahauling.create') }}" class="btn btn-primary mb-3">Tambah Nota</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Sopir</th>
                <th>Tarif / Rit</th>
                <th>Jumlah Rit</th>
                <th>Total</th>
                <th>Nota</th>
                <th>Bukti Transfer</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notaHaulings as $nota)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $nota->sopir->nama }}</td>
                    <td>Rp{{ number_format($nota->tarif_per_rit, 0, ',', '.') }}</td>
                    <td>{{ $nota->jumlah_ritase }}</td>
                    <td>Rp{{ number_format($nota->total_pemasukan, 0, ',', '.') }}</td>
                    <td><a href="{{ Storage::url($nota->bukti_nota) }}" target="_blank">Lihat Nota</a></td>
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
                    <td colspan="8" class="text-center">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
