<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="{{ route('owner.dashboard') }}" class="brand-link">
    <span class="brand-text font-weight-light">Dashboard Owner</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="{{ route('owner.dashboard') }}" class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
    <a href="{{ route('owner.ritase.index') }}" class="nav-link">
        <i class="fas fa-truck-loading nav-icon"></i>
        <p>Laporan Ritase</p>
    </a>
</li>


        <li class="nav-item">
          <a href="{{ route('owner.maintenance.index') }}" class="nav-link {{ request()->routeIs('owner.maintenance.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tools"></i>
            <p>Data Maintenance</p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs('owner.nota.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('owner.nota.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>
              Nota
              <i class="right fas fa-angle-left"></i>
              @if(isset($totalNotaMenunggu) && $totalNotaMenunggu > 0)
                <span class="badge badge-danger right">{{ $totalNotaMenunggu }}</span>
              @endif
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('owner.nota.bbm') }}" class="nav-link {{ request()->routeIs('owner.nota.bbm') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nota BBM
                  @if(isset($totalNotaBbmMenunggu) && $totalNotaBbmMenunggu > 0)
                    <span class="badge badge-warning ml-2">{{ $totalNotaBbmMenunggu }}</span>
                  @endif
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('owner.nota-hauling.index') }}" class="nav-link {{ request()->routeIs('owner.nota.hauling') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nota Hauling</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('owner.nota.perbaikan') }}" class="nav-link {{ request()->routeIs('owner.nota.perbaikan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nota Perbaikan</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('owner.kerusakan.index') }}" class="nav-link {{ request()->routeIs('owner.kerusakan.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-exclamation-triangle"></i>
            <p>
              Kerusakan
              @if(isset($totalKerusakanMenunggu) && $totalKerusakanMenunggu > 0)
                <span class="badge badge-danger right">{{ $totalKerusakanMenunggu }}</span>
              @endif
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('owner.keuangan.index') }}" class="nav-link {{ request()->routeIs('owner.keuangan.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-wallet"></i>
            <p>Rekap Keuangan</p>
          </a>
        </li>

        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link text-left btn btn-link text-white">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </button>
          </form>
        </li>

      </ul>
    </nav>
  </div>
</aside>
