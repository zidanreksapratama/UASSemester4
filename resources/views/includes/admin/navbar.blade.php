<nav class="main-header navbar navbar-expand navbar-dark bg-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <!-- Sidebar Toggle-->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- Navbar Brand-->
        <li class="nav-item">
            <a class="navbar-brand ps-3" href="{{ route('dashboard.index') }}">
                SPK {{ auth()->user()->level }}
            </a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Welcome Message -->
        <li class="nav-item d-none d-md-inline-block">
            <span class="nav-link text-white">Welcome back, {{ auth()->user()->name }}</span>
        </li>
        <!-- Fullscreen Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
