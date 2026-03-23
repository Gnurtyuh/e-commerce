<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" style="gap:8px;">
                <span style="width:28px;height:28px;border-radius:50%;background:var(--primary-bg);display:inline-flex;align-items:center;justify-content:center;color:var(--primary);font-weight:700;font-size:0.75rem;">
                    {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                </span>
                <span>{{ session('admin_name', 'Admin') }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
