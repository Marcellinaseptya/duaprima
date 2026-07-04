@extends('layout.main')

@section('content')
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid mt-4">

      {{-- Info Box 1 --}}
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card text-white bg-primary p-3 shadow">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-cash-coin display-4 me-3"></i>
              <div>
                <h5 class="card-title">Total Pemasukan</h5>
                <p class="card-text fs-5">Rp {{ number_format($totalPemasukan) }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-success p-3 shadow">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-currency-dollar display-4 me-3"></i>
              <div>
                <h5 class="card-title">Total Pengeluaran</h5>
                <p class="card-text fs-5">Rp {{ number_format($totalPengeluaran) }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-dark bg-warning p-3 shadow">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-bank2 display-4 me-3"></i>
              <div>
                <h5 class="card-title">Total Peminjaman</h5>
                <p class="card-text fs-5">Rp {{ number_format($totalPeminjaman) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Info Box 2 --}}
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card text-white bg-info p-3 shadow">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-truck display-4 me-3"></i>
              <div>
                <h5 class="card-title">Total Truk Aktif</h5>
                <p class="card-text fs-5">{{ $totalTrukAktif }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-success p-3 shadow">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-person-badge display-4 me-3"></i>
              <div>
                <h5 class="card-title">Total Sopir Aktif</h5>
                <p class="card-text fs-5">{{ $totalSopirAktif }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-danger p-3 shadow">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-tools display-4 me-3"></i>
              <div>
                <h5 class="card-title">Total Kerusakan</h5>
                <p class="card-text fs-5">{{ $totalKerusakan }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Charts --}}
      <div class="row">
        <div class="col-md-6">
          <div class="card p-3 shadow">
            <h5 class="mb-3">Grafik Perjalanan</h5>
            <canvas id="lineChart" height="200"></canvas>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card p-3 shadow">
            <h5 class="mb-3">Kategori Pengeluaran</h5>
            <canvas id="pieChart" height="200"></canvas>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const perjalananLabels = {!! json_encode($perjalanan->pluck('tanggal')->reverse()) !!};
  const perjalananData = {!! json_encode($perjalanan->pluck('total')->reverse()) !!};

  new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: perjalananLabels,
      datasets: [{
        label: 'Jumlah Perjalanan',
        data: perjalananData,
        backgroundColor: 'rgba(13,110,253,0.2)',
        borderColor: 'rgba(13,110,253,1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4
      }]
    }
  });

  const pieLabels = {!! json_encode($transaksiOperasional->pluck('kategori')) !!};
  const pieData = {!! json_encode($transaksiOperasional->pluck('total')) !!};

  new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
      labels: pieLabels,
      datasets: [{
        data: pieData,
        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d']
      }]
    }
  });
</script>
@endsection
