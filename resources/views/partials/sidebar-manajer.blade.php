<!-- SIDEBAR MANAJER -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <img src="{{ asset('assets/icons/CV.DSP.ico') }}" alt="Logo" class="mr-3 ml-2" height="55" width="40">
    <span class="brand-text font-weight-light">ManajerDSP</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        {{-- DASHBOARD --}}
        <li class="nav-header">DASHBOARD</li>
        <li class="nav-item">
          <a href="{{ route('manajer.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        {{-- PENGELOLAAN --}}
        <li class="nav-header">MANAJEMEN</li>
        <li class="nav-item">
          <a href="{{ route('manajer.jadwal.index') }}" class="nav-link">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>Jadwal Operasional</p>
          </a>
        </li>

        {{-- APPROVAL --}}
        <li class="nav-header">PERSETUJUAN</li>

<li class="nav-item">
  <a href="{{ route('manajer.kerusakan.index') }}" class="nav-link">
    <i class="fas fa-exclamation-triangle nav-icon"></i>
    <p>Laporan Kerusakan</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('manajer.maintenance.index') }}" class="nav-link">
    <i class="fas fa-tools nav-icon"></i>
    <p>Data Maintenance</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('manajer.trippulang.index') }}" class="nav-link">
    <i class="fas fa-truck-loading nav-icon"></i>
    <p>Data Trip Pulang</p>
  </a>
</li>

        {{-- NOTA & PENGELUARAN --}}
        <li class="nav-header">NOTA SOPIR</li>
        <li class="nav-item">
          <a href="{{ route('manajer.faktur.index') }}" class="nav-link">
            <i class="fas fa-file-invoice nav-icon"></i>
            <p>Data Faktur</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('manajer.nota-hauling.index') }}" class="nav-link">
            <i class="fas fa-file-invoice-dollar nav-icon"></i>
            <p>Nota Hauling</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('manajer.nota-pengeluaran.index') }}" class="nav-link">
            <i class="fas fa-receipt nav-icon"></i>
            <p>Nota Pengeluaran</p>
          </a>
        </li>

        {{-- LOGOUT --}}
        <li class="nav-header">LAINNYA</li>
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Keluar</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>