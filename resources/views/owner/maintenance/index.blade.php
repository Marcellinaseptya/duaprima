@extends('layout.main')
@include('partials.sidebar-owner')

@section('title', 'Laporan Maintenance')

@section('content')
<div class="container mt-4">
    <h3>Laporan Maintenance</h3>

    {{-- Filter Bulan dan Tahun --}}
    <form method="GET" action="{{ route('owner.maintenance.index') }}" class="form-inline mb-3">
        <label for="bulan" class="mr-2">Bulan:</label>
        <select name="bulan" id="bulan" class="form-control mr-3">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select>

        <label for="tahun" class="mr-2">Tahun:</label>
        <select name="tahun" id="tahun" class="form-control mr-3">
            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    {{-- Tabel Data Maintenance --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Truk</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Deskripsi</th>
                        <th>Biaya</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($maintenances as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->mastertruk->plat_nomor ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d-m-Y') }}</td>
                            <td>{{ $item->deskripsi_perbaikan }}</td>
                            <td>Rp{{ number_format($item->biaya_servis, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->foto_bukti)
                                    <a href="{{ asset('storage/' . $item->foto_bukti) }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data maintenance.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Total Biaya --}}
    <div class="mt-3">
        <h5>Total Biaya Maintenance Bulan Ini: 
            <strong>Rp{{ number_format($totalBiayaMaintenance, 0, ',', '.') }}</strong>
        </h5>
    </div>
</div>
@endsection
