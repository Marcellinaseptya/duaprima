@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Dashboard Manajer')

@section('content')
<section class="content">
  <div class="container-fluid px-3 mt-4">
    <h1 class="mb-2">Dashboard Manajer</h1>
    <p class="text-muted mb-4">Selamat datang, Manajer. Berikut adalah ringkasan aktivitas armada.</p>

    {{-- Card Ringkasan --}}
    <div class="row mb-4 g-4">
      <div class="col-md-4">
        <div class="card bg-danger text-white shadow p-3">
          <h6>Total Laporan Kerusakan</h6>
          <h3>{{ $totalLaporan }}</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-success text-white shadow p-3">
          <h6>Total Perbaikan</h6>
          <h3>{{ $totalPerbaikan }}</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-primary text-white shadow p-3">
          <h6>Total Jadwal Operasional</h6>
          <h3>{{ $totalJadwal }}</h3>
        </div>
      </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="row mb-4 g-4">
      <div class="col-md-6">
        <div class="card shadow p-3 d-flex justify-content-between flex-row align-items-center">
          <div><h6 class="mb-0">Tambah Jadwal Operasional</h6></div>
          <a href="{{ route('manajer.jadwal.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
          </a>
        </div>
      </div>
    </div>

    {{-- Histori --}}
    <div class="row mb-4 g-4">
      {{-- Laporan Kerusakan --}}
      <div class="col-md-6">
        <div class="card shadow p-3">
          <h5 class="mb-3">Histori Laporan Kerusakan</h5>
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Sopir</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($laporanKerusakan as $i => $laporan)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}</td>
                  <td>{{ $laporan->sopir->nama ?? '-' }}</td>
                  <td>{{ ucfirst($laporan->status) }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center">Belum ada laporan</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- Perbaikan --}}
      <div class="col-md-6">
        <div class="card shadow p-3">
          <h5 class="mb-3">Histori Perbaikan</h5>
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Truk</th>
                  <th>Biaya</th>
                </tr>
              </thead>
              <tbody>
                @forelse($historiPerbaikan as $i => $m)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ \Carbon\Carbon::parse($m->tanggal_perbaikan)->format('d-m-Y') }}</td>
                  <td>{{ $m->truk->plat_nomor ?? '-' }}</td>
                  <td>Rp {{ number_format($m->biaya, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center">Belum ada perbaikan</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Jadwal Operasional --}}
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card shadow p-3">
          <h5 class="mb-3">Histori Jadwal Operasional</h5>
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Sopir</th>
                  <th>Truk</th>
                  <th>Tujuan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($jadwalOperasional as $i => $j)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d-m-Y') }}</td>
                  <td>{{ $j->sopir->nama ?? '-' }}</td>
                  <td>{{ $j->truk->plat_nomor ?? '-' }}</td>
                  <td>{{ $j->tujuan }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center">Belum ada jadwal</td>
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
@endsection
