<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/icons/CV.DSP.ico') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
        <span class="brand-text font-weight-light">AdminDuaPrima</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">

                {{-- DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">MASTER DATA</li>

                {{-- PENGGUNA --}}
                <li class="nav-item {{ request()->routeIs('users*', 'admin.sopir*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('users*', 'admin.sopir*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pengguna
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            {{-- PERBAIKAN: users -> users.index --}}
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sopir.index') }}" class="nav-link {{ request()->routeIs('admin.sopir*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Sopir</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- DATA TRUK --}}
                <li class="nav-item">
                    <a href="{{ route('admin.mastertruk.index') }}" class="nav-link {{ request()->routeIs('admin.mastertruk*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Master Truk</p>
                    </a>
                </li>

                {{-- KLIEN --}}
                <li class="nav-item">
                    <a href="{{ route('admin.klien.index') }}" class="nav-link {{ request()->routeIs('admin.klien*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Data Klien</p>
                    </a>
                </li>

                <li class="nav-header">OPERASIONAL & TEKNIS</li>

                {{-- SPAREPART & MAINTENANCE --}}
                <li class="nav-item {{ request()->routeIs('admin.sparepart*', 'admin.pembelian*', 'admin.maintenance*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.sparepart*', 'admin.pembelian*', 'admin.maintenance*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Maintenance
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.sparepart.index') }}" class="nav-link {{ request()->routeIs('admin.sparepart*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sparepart</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pembelian.index') }}" class="nav-link {{ request()->routeIs('admin.pembelian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembelian Sparepart</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.maintenance.index') }}" class="nav-link {{ request()->routeIs('admin.maintenance*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Maintenance</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- OPERASIONAL TRIP --}}
                <li class="nav-item {{ request()->routeIs('admin.trip*', 'admin.ritase*', 'admin.jadwal*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.trip*', 'admin.ritase*', 'admin.jadwal*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck-moving"></i>
                        <p>
                            Operasional
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.tripberangkat.index') }}" class="nav-link {{ request()->routeIs('admin.tripberangkat*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trip Berangkat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.trippulang.index') }}" class="nav-link {{ request()->routeIs('admin.trippulang*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trip Pulang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ritase.index') }}" class="nav-link {{ request()->routeIs('admin.ritase*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Ritase</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.jadwal-operasional.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal-operasional*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal Operasional</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">FINANCE & REPORTS</li>

                {{-- KEUANGAN --}}
                <li class="nav-item">
                    <a href="{{ route('admin.laporan_keuangan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan_keuangan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Laporan Keuangan</p>
                    </a>
                </li>

                {{-- LAPORAN --}}
                <li class="nav-item {{ request()->routeIs('admin.nota-hauling*', 'admin.laporankerusakan*', 'admin.invoice*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.nota-hauling*', 'admin.laporankerusakan*', 'admin.invoice*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Dokumen & Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.nota-hauling.index') }}" class="nav-link {{ request()->routeIs('admin.nota-hauling*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nota Hauling</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            {{-- PERBAIKAN: admin.laporan-kerusakan.index -> admin.laporankerusakan.index --}}
                            <a href="{{ route('admin.laporankerusakan.index') }}" class="nav-link {{ request()->routeIs('admin.laporankerusakan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Kerusakan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.invoice.index') }}" class="nav-link {{ request()->routeIs('admin.invoice*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Invoice</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>