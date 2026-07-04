@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Dashboard Sopir')

@section('content')
<section class="content">
  <div class="container-fluid px-3 mt-4">
    <h4 class="mb-4">Dashboard Sopir – CV. Dua Sahabat Prima</h4>

    @php
      $namaSopir = Auth::user()->nama;
      $ucapan = [
          "Semangat bekerja hari ini 💪",
          "Jaga kesehatan dan fokus ya 🚛",
          "Semoga perjalanan lancar 🌤️",
          "Terima kasih sudah bekerja keras!",
          "Tetap semangat, hasil takkan mengkhianati usaha 👊",
      ];
      $pesan = $ucapan[array_rand($ucapan)];
    @endphp

    <div class="alert alert-primary shadow text-center mb-4">
      <h5>Hai, {{ $namaSopir }}!</h5>
      <p class="mb-0">{{ $pesan }}</p>
    </div>

    {{-- ALERT JIKA DATA SOPIR TIDAK DITEMUKAN --}}
    @if(!$sopir)
    <div class="alert alert-danger shadow border-0 mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
            <div>
                <h5 class="mb-0">Profil Belum Lengkap!</h5>
                <p class="mb-0">Akun Anda ({{ Auth::user()->nama }}) belum terhubung ke data Master Sopir. Silakan hubungi Admin untuk melakukan sinkronisasi agar Anda dapat melihat jadwal perjalanan.</p>
            </div>
        </div>
    </div>
    @endif {{-- <--- Tadi kamu lupa menutup bagian ini --}}

    {{-- Ringkasan --}}
    <div class="row mb-4">
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="card shadow p-3 text-center">
          <h6>Total Perjalanan Selesai</h6>
          <h3>{{ $totalPerjalanan }}</h3>
        </div>
      </div>
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="card shadow p-3 text-center">
          <h6>Truk Anda</h6>
          <h4>{{ $platNomor }}</h4>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow p-3 text-center">
          <h6>Sisa Pinjaman</h6>
          <h4>Rp {{ number_format($sisaPinjaman, 0, ',', '.') }}</h4>
          <span class="badge {{ $statusPelunasan === 'LUNAS' ? 'badge-success' : 'badge-danger' }}">
            {{ $statusPelunasan }}
          </span>
        </div>
      </div>
    </div>

    {{-- Jadwal Aktif --}}
    <div class="card shadow p-3 mb-4">
      <h5>Jadwal Perjalanan Aktif</h5>
      @if($jadwalAktif)
        <p><strong>Tujuan:</strong> {{ $jadwalAktif->tujuan }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($jadwalAktif->tanggal)->format('d-m-Y') }}</p>
        <p><strong>Status:</strong> {{ $jadwalAktif->status }}</p>
        <p><strong>Truk:</strong> {{ $platNomor }}</p>

        @if($jadwalAktif->status === 'Siap Berangkat')
            <form method="POST" action="{{ route('sopir.jadwal.mulai', $jadwalAktif->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Mulai Perjalanan</button>
            </form>
        @elseif($jadwalAktif->status === 'Berangkat')
            <form method="POST" action="{{ route('sopir.jadwal.selesai', $jadwalAktif->id) }}">
                @csrf
                <button type="submit" class="btn btn-success mb-2">Selesaikan Perjalanan</button>
            </form>
            <form method="POST" action="{{ route('sopir.jadwal.batal', $jadwalAktif->id) }}">
                @csrf
                <input type="text" name="alasan_batal" class="form-control mb-2" placeholder="Alasan batal" required>
                <button class="btn btn-danger btn-sm">Ajukan Batal</button>
            </form>
        @elseif($jadwalAktif->status === 'Pulang')
            <span class="text-info">Perjalanan pulang, isi trip pulang.</span>
        @elseif($jadwalAktif->status === 'Selesai' || $jadwalAktif->status === 'Dibatalkan oleh Sopir')
            <span class="text-muted">Perjalanan selesai / dibatalkan.</span>
            @if($jadwalAktif->alasan_batal)
                <p><strong>Alasan batal:</strong> {{ $jadwalAktif->alasan_batal }}</p>
            @endif
        @endif
      @else
        <p>Tidak ada jadwal aktif.</p>
      @endif
    </div>

    {{-- Histori Jadwal --}}
    <div class="card shadow p-3 mb-4">
      <h5>Histori Jadwal Terakhir</h5>
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Tujuan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($historiJadwal as $jadwal)
            <tr>
              <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y') }}</td>
              <td>{{ $jadwal->tujuan }}</td>
              <td>
                <span class="badge
                  {{ $jadwal->status === 'Menunggu' ? 'badge-secondary' : '' }}
                  {{ $jadwal->status === 'Siap Berangkat' ? 'badge-warning' : '' }}
                  {{ $jadwal->status === 'Berangkat' ? 'badge-primary' : '' }}
                  {{ $jadwal->status === 'Pulang' ? 'badge-info' : '' }}
                  {{ $jadwal->status === 'Selesai' ? 'badge-success' : '' }}
                  {{ $jadwal->status === 'Dibatalkan oleh Sopir' ? 'badge-danger' : '' }}">
                  {{ $jadwal->status }}
                </span>
              </td>
            </tr>
          @empty
            <tr><td colspan="3" class="text-center">Belum ada jadwal</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Histori Nota Perjalanan --}}
    <div class="card shadow p-3">
      <h5>Histori Nota Perjalanan</h5>
      @if($belumUnggahNota)
        <div class="alert alert-warning py-2 mb-3">
          <i class="fas fa-exclamation-triangle"></i>
          Anda belum meng-upload nota untuk perjalanan terakhir yang <b>Selesai</b>.
        </div>
      @endif

      <table class="table table-bordered table-sm mb-0">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Bukti</th>
          </tr>
        </thead>
        <tbody>
          @forelse($laporanPerjalanan as $nota)
            <tr>
              <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
              <td>{{ $nota->keterangan ?? '-' }}</td>
              <td class="text-center">
                @if($nota->bukti_transfer)
                  <a href="{{ Storage::url($nota->bukti_transfer) }}" target="_blank">Lihat Bukti</a>
                @else
                  -
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="3" class="text-center">Belum ada nota yang di-upload</td></tr>
          @endforelse
        </tbody>
      </table>

      <a href="{{ route('sopir.laporan-nota-hauling.index') }}" class="d-block mt-2">
        Lihat semua ({{ $totalNota }}) &raquo;
      </a>
    </div>

  </div>
</section>
@endsection