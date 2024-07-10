<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <span class="brand-text font-weight-light">SPK {{ auth()->user()->level }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <!-- Master Data -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->level == 'ADMIN')
                            <li class="nav-item">
                                <a href="{{ route('kriteria.index') }}"
                                    class="nav-link {{ Request::is('dashboard/kriteria*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-table-columns"></i>
                                    <p>Data Kriteria</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('student.index') }}"
                                class="nav-link {{ Request::is('dashboard/student*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Data Siswa</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('alternatif.index') }}"
                                class="nav-link {{ Request::is('dashboard/alternatif*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Data Alternatif</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Perbandingan -->
                <li class="nav-item">
                    <a href="{{ route('perbandingan.index') }}"
                        class="nav-link {{ Request::is('dashboard/perbandingan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>Perbandingan</p>
                    </a>
                </li>
                <!-- Rangking -->
                <li class="nav-item">
                    <a href="{{ route('rank.index') }}"
                        class="nav-link {{ Request::is('dashboard/ranking*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-ol"></i>
                        <p>Rangking</p>
                    </a>
                </li>
                <!-- Master Pengguna (Hanya Admin) -->
                @if(auth()->user()->level == 'ADMIN')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Master Pengguna
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                    class="nav-link {{ Request::is('dashboard/users*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>Data Pengguna</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <!-- Ubah Profil -->
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}"
                        class="nav-link {{ Request::is('dashboard/profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Ubah Profil</p>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer p-3 fixed-bottom">
            <div class="small text-white font-weight-bold">Logged in as : <span>{{ auth()->user()->level }}</span></div>
        </div>
    </div>
    <!-- /.sidebar -->
</aside>