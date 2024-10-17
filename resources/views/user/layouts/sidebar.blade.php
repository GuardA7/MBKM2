<nav class="sb-sidenav accordion sb-sidenav-light shadow" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <!-- Core Section -->
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="/">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Menu</div>
            <a class="nav-link" href="/pelatihan">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                List Pelatihan
            </a>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseGrafik" aria-expanded="false" aria-controls="collapseGrafik">
                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                Sertifikat
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseGrafik" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="/certificates">Lihat Sertifikat
                    </a>
                    <a class="nav-link" href="/sertifikat/upload">Upload Sertifikat</a>
                </nav>
            </div>

            <!-- Data Section -->
            <div class="sb-sidenav-menu-heading">Data</div>

            <!-- Grafik with Dropdown -->
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseGrafik" aria-expanded="false" aria-controls="collapseGrafik">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Grafik
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseGrafik" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="/grafik/line">Grafik Sertifikat
                    </a>
                    <a class="nav-link" href="/grafik/bar">Presentase Mahasiswa</a>
                </nav>
            </div>

            <!-- Other Menu Items -->
        </div>
    </div>

    <!-- Footer Section -->
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        Mahasiswa
    </div>
</nav>
