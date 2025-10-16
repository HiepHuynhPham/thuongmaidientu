<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="/admin">Start Bootstrap</a>
        <!-- Sidebar Toggle (Nằm bên trái) -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-auto" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar (Nằm sát bên phải) -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="dropdown-item">Đăng xuất</button>
                        </form>
                    </li>

                </ul>
            </li>
        </ul>
    </nav>
</body>