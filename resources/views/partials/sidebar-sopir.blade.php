<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('sopir.dashboard') }}" class="brand-link d-flex align-items-center">
        <img src="{{ asset('assets/icons/CV.DSP.ico') }}" 
             alt="Logo" 
             class="brand-image img-circle elevation-3"
             style="opacity: .8; width: 35px; height: 35px;">
        <span class="brand-text font-weight-light ml-2">SopirDuaPrima</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex border-bottom-0">
            <div class="image">
                <i class="fas fa-user-circle fa-2x text-light"></i>
            </div>
            <div class="info">
                <a href="#" class="d-block text-white font-weight-bold">{{ auth()->user()->nama }}</a>
                <span class="text-xs text-muted"><i class="fa fa-circle text-success text-xs"></i> Online</span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('sopir.dashboard') }}" class="nav-link {{ request()->routeIs('sopir.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">AKTIVITAS JALAN</li>

                <li class="nav-item">
                    <a href="{{ route('sopir.trip-berangkat.index') }}" class="nav-link {{ request()->is('sopir/trip-berangkat*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-paper-plane text-info"></i>
                        <p>Trip Berangkat</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('sopir.trip-pulang.index') }}" class="nav-link {{ request()->is('sopir/trip-pulang*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home text-success"></i>
                        <p>Trip Pulang</p>
                    </a>
                </li>

                <li class="nav-header">ADMINISTRASI</li>

                <li class="nav-item">
                    <a href="{{ route('sopir.laporan-kerusakan.index') }}" class="nav-link {{ request()->is('sopir/laporan-kerusakan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tools text-warning"></i>
                        <p>Laporan Kerusakan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('sopir.nota-pengeluaran.index') }}" class="nav-link {{ request()->is('sopir/nota*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt text-danger"></i>
                        <p>Nota BBM & Parkir</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('sopir.laporan-nota-hauling.index') }}" class="nav-link {{ request()->is('sopir/nota-hauling*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar text-primary"></i>
                        <p>Nota Hauling</p>
                    </a>
                </li>

                <li class="nav-header">SISTEM</li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link text-warning" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Keluar Aplikasi</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>