<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Dashboard</div>
                <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }} ">
                    <div class="sb-nav-link-icon">
                        <i class="pe-1 bi bi-display"></i>
                    </div>
                    Dashboard
                </a>
                @can('admin')
                    <a href="{{ route('barang.index') }}" class="nav-link {{ Request::is('barang*') ? 'active' : '' }}">
                        <div class="sb-nav-link-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        Barang
                    </a>
                    <a href="{{ route('toko.index') }}" class="nav-link {{ Request::is('toko*') ? 'active' : '' }}">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-building"></i>
                        </div>
                        Toko
                    </a>
                    <a href="{{ route('driver.index') }}" class="nav-link {{ Request::is('driver*') ? 'active' : '' }}">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-person"></i>
                        </div>
                        Driver
                    </a>

                    <a class="nav-link collapsed {{ Request::is('pengiriman*') ? 'active' : '' }}" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapsePengiriman" aria-expanded="false"
                        aria-controls="collapsePengiriman">
                        <div class="sb-nav-link-icon">
                            <i class="bi bi-list"></i>
                        </div>
                        Pengiriman
                        <div class="sb-sidenav-collapse-arrow active"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse {{ Request::is('pengiriman*') ? 'show' : '' }}" id="collapsePengiriman"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav rounded">
                            <div class="ps-2">
                                <a href="/pengiriman/create"
                                    class="nav-link {{ Request::is('pengiriman/create*') ? 'active' : '' }}">Tambah</a>
                                <a href="/pengiriman/pickup"
                                    class="nav-link {{ Request::is('pengiriman/pickup*') ? 'active' : '' }}">Pickup</a>

                            </div>
                        </nav>
                    </div>

                    <a class="nav-link collapsed {{ Request::is('laporan*') ? 'active' : '' }}" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false"
                        aria-controls="collapseLaporan">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-clipboard"></i>
                        </div>
                        Laporan
                        <div class="sb-sidenav-collapse-arrow active"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse {{ Request::is('laporan*') ? 'show' : '' }}" id="collapseLaporan"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav rounded">
                            <div class="ps-2">
                                <a href="/laporan/pengiriman"
                                    class="nav-link {{ Request::is('laporan/pengiriman*') ? 'active' : '' }}">Pengiriman</a>
                                <a href="/laporan/driver"
                                    class="nav-link {{ Request::is('laporan/driver*') ? 'active' : '' }}">Driver</a>
                            </div>
                        </nav>
                    </div>
                @endcan

                @can('toko')
                    <a href="/store" class="nav-link {{ Request::is('store') ? 'active' : '' }}">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-check"></i>
                        </div>
                        Konfirmasi
                    </a>
                    <a href="/laporan/store" class="nav-link {{ Request::is('laporan/store*') ? 'active' : '' }}">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-clipboard"></i>
                        </div>
                        Laporan
                    </a>
                @endcan

                @can('manajer')
                    <a class="nav-link collapsed {{ Request::is('laporan*') ? 'active' : '' }}" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false"
                        aria-controls="collapseLaporan">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-clipboard"></i>
                        </div>
                        Laporan
                        <div class="sb-sidenav-collapse-arrow active"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse {{ Request::is('laporan*') ? 'show' : '' }}" id="collapseLaporan"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav rounded">
                            <div class="ps-2">
                                <a href="/laporan/pengiriman"
                                    class="nav-link {{ Request::is('laporan/pengiriman*') ? 'active' : '' }}">Pengiriman</a>
                                <a href="/laporan/driver"
                                    class="nav-link {{ Request::is('laporan/driver*') ? 'active' : '' }}">Driver</a>
                            </div>
                        </nav>
                    </div>
                @endcan

                @can('driver')
                    <a href="/laporan/driver" class="nav-link {{ Request::is('laporan/driver') ? 'active' : '' }}">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-truck"></i>
                        </div>
                        Pengiriman
                    </a>
                    <a href="/laporan/driver/pembayaran"
                        class="nav-link {{ Request::is('laporan/driver/pembayaran') ? 'active' : '' }}">
                        <div class="sb-nav-link-icon">
                            <i class="pe-1 bi bi-clipboard"></i>
                        </div>
                        Pembayaran
                    </a>
                @endcan

            </div>
        </div>
    </nav>
</div>
