<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a href="" class="ms-3">
        <img src="/image/logo.svg" width="50" height="50">
    </a>
    <a class="navbar-brand ps-3" href="">Lawson</a>
    <!-- Navbar-->
    <div class="navbar-nav ms-auto">
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i> {{ $nama }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/password">Ganti Password</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
