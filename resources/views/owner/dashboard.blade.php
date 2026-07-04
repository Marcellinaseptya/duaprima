@extends('layout.main')
@include('partials.sidebar-owner')

@section('title', 'Dashboard Owner')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-4">Dashboard Owner</h1>

    {{-- Ringkasan Nota & Laporan --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <h5>Nota Hauling Menunggu</h5>
                    <h3>{{ $totalNotaHauling }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <h5>Nota BBM Menunggu</h5>
                    <h3>{{ $totalNotaBbm }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body text-center">
                    <h5>Nota Perbaikan Menunggu</h5>
                    <h3>{{ $totalNotaPerbaikan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <h5>Laporan Kerusakan Disetujui</h5>
                    <h3>{{ $totalKerusakan }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Ringkasan Keuangan --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Pendapatan Bersih</h5>
                    <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Gaji Sopir (25%)</h5>
                    <h3>Rp {{ number_format($totalGajiSopir, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Untung CV (75%)</h5>
                    <h3>Rp {{ number_format($totalUntungCV, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Maintenance</h5>
                    <h3>Rp {{ number_format($totalMaintenance, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Sparepart</h5>
                    <h3>Rp {{ number_format($totalSparepart, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Pie Chart Peminjaman --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <canvas id="piePeminjaman"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="pieKerusakan"></canvas>
        </div>
    </div>

    {{-- Bar Chart Pemasukan & Pengeluaran --}}
    <div class="row">
        <div class="col-md-6">
            <canvas id="barPemasukan"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="barPengeluaran"></canvas>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Peminjaman
    const piePeminjaman = new Chart(document.getElementById('piePeminjaman'), {
        type: 'pie',
        data: @json($dataPiePeminjaman),
        options: {}
    });

    // Pie Kerusakan
    const pieKerusakan = new Chart(document.getElementById('pieKerusakan'), {
        type: 'pie',
        data: @json($dataPieKerusakan),
        options: {}
    });

    // Bar Pemasukan
    const barPemasukan = new Chart(document.getElementById('barPemasukan'), {
        type: 'bar',
        data: @json($dataBarPemasukan),
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Bar Pengeluaran
    const barPengeluaran = new Chart(document.getElementById('barPengeluaran'), {
        type: 'bar',
        data: @json($dataBarPengeluaran),
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
