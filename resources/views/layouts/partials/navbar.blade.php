<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.users.index') }}" class="nav-link">Users</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.file-management.index') }}" class="nav-link">File Management</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item d-none d-md-inline-block">
            <span class="nav-link text-muted">Exam Days! Admin Panel</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <span class="dropdown-item-text">{{ auth()->user()?->name }}</span>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm btn-block">Logout</button>
                </form>
            </div>
        </li>
    </ul>
</nav>
