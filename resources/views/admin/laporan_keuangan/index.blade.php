@extends('layout.main')
@include('partials.sidebar-admin')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">📊 Laporan & Rekap Gaji Sopir</h1>

    {{-- Filter --}}
    <div class="card shadow-sm mb-4 no-print">
        <div class="card-body bg-light">
            <form action="{{ route('admin.laporan_keuangan.index') }}" method="GET" class="row">
                <div class="col-md-4">
                    <label class="small font-weight-bold">Mulai</label>
                    <input type="date" name="start_date" value="{{ $start }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="small font-weight-bold">Selesai</label>
                    <input type="date" name="end_date" value="{{ $end }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Filter Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Ringkasan Gaji Sopir (Fitur Baru) --}}
    <div class="card shadow-sm mb-4 border-left-info">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-wallet mr-2"></i>Rekap Gaji Sopir (Periode Ini)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-info text-white">
                        <tr class="text-center">
                            <th>Nama Sopir</th>
                            <th>Total Ritase</th>
                            <th>Total Gaji (25%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gajiPerSopir as $nama => $data)
                        <tr>
                            <td class="font-weight-bold">{{ $nama }}</td>
                            <td class="text-center">{{ $data['total_rit'] }} Rit</td>
                            <td class="text-right font-weight-bold text-primary">
                                Rp {{ number_format($data['total_gaji'], 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Tidak ada data trip.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabs Detail --}}
    <div class="card shadow-sm">
        <div class="card-header p-0">
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item"><a class="nav-link active font-weight-bold" data-toggle="tab" href="#tab-trip">Detail Ritase</a></li>
                <li class="nav-item"><a class="nav-link font-weight-bold text-danger" data-toggle="tab" href="#tab-main">Biaya Maintenance</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-trip">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>Rit</th>
                                <th>Gaji (25%)</th>
                                <th>CV (75%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                            @php
                                $bersih = (($trip->ritase * $trip->tarif_per_rit) + ($trip->uang_makan ?? 0) + ($trip->muatan_netto > 11500 ? 60000 : 0)) - ($trip->biaya_bbm ?? 0);
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($trip->waktu_selesai)->format('d/m/y') }}</td>
                                <td>{{ $trip->tripBerangkat->sopir->nama ?? '-' }}</td>
                                <td>{{ $trip->ritase }}</td>
                                <td class="text-primary">Rp {{ number_format($bersih * 0.25) }}</td>
                                <td class="font-weight-bold">Rp {{ number_format($bersih * 0.75) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="tab-main">
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Armada</th>
                                <th>Deskripsi</th>
                                <th>Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenance as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d/m/y') }}</td>
                                <td>{{ $item->mastertruk->plat_nomor ?? '-' }}</td>
                                <td>{{ $item->deskripsi_perbaikan }}</td>
                                <td class="text-danger font-weight-bold">Rp {{ number_format($item->biaya_servis) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
