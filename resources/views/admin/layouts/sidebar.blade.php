<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light shadow" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <!-- Core Dashboard -->
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Akun User Section -->
                <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    User
                </a>

                <!-- Akademik Section -->
                <div class="sb-sidenav-menu-heading">Akademik</div>
                <a class="nav-link {{ request()->is('admin/jurusan*') ? 'active' : '' }}"
                    href="{{ route('admin.jurusan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                    Jurusan
                </a>
                <a class="nav-link {{ request()->is('admin/kelas*') ? 'active' : '' }}"
                    href="{{ route('admin.kelas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chalkboard"></i></div>
                    Kelas
                </a>
                <a class="nav-link {{ request()->is('admin/prodi*') ? 'active' : '' }}"
                    href="{{ route('admin.prodi.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-school"></i></div>
                    Prodi
                </a>

                <!-- Data Section -->
                <div class="sb-sidenav-menu-heading">Data</div>
                <a class="nav-link {{ request()->is('admin/grafik*') ? 'active' : '' }}"
                    href="{{ route('admin.grafik.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                    Grafik
                </a>
                <a class="nav-link {{ request()->is('admin/lsp*') ? 'active' : '' }}"
                    href="{{ route('admin.lsp.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    LSP
                </a>
                <a class="nav-link {{ request()->is('admin/sertifikat*') ? 'active' : '' }}"
                    href="{{ route('admin.sertifikat.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-award"></i></div>
                    Sertifikat
                </a>

                <!-- Pelatihan Section -->
                <div class="sb-sidenav-menu-heading">Pelatihan</div>
                <a class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}"
                    href="{{ route('admin.kategori.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                    Kategori
                </a>
                <a class="nav-link {{ request()->is('admin/pelatihan*') ? 'active' : '' }}"
                    href="{{ route('admin.pelatihan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    List Pelatihan
                </a>

                <!-- Settings Section -->
                <div class="sb-sidenav-menu-heading">Setting</div>
                <a class="nav-link" href="{{ route('logout') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <span>{{ Auth::user()->nama }}</span>
        </div>
    </nav>
</div>

<script>
    $(document).ready(function() {
        // Toggle and save collapse state
        $('.collapse').on('shown.bs.collapse', function() {
            var targetId = $(this).attr('id');
            localStorage.setItem(targetId, 'show');
        }).on('hidden.bs.collapse', function() {
            var targetId = $(this).attr('id');
            localStorage.setItem(targetId, 'hide');
        });

        // Restore collapse state
        $('.collapse').each(function() {
            var targetId = $(this).attr('id');
            if (localStorage.getItem(targetId) === 'show') {
                $(this).collapse('show');
            } else {
                $(this).collapse('hide');
            }
        });

        // Save scroll position before navigating
        $(window).on('beforeunload', function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        // Restore scroll position on page load
        $(window).on('load', function() {
            var scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, scrollPosition);
            }
        });

        // Close all dropdowns and reset scroll position on Dashboard click
        $('.nav-link[href="{{ route('admin.dashboard') }}"]').on('click', function() {
            $('.collapse').collapse('hide');
            $('.collapse').each(function() {
                var targetId = $(this).attr('id');
                localStorage.setItem(targetId, 'hide');
            });

            // Reset scroll position for Dashboard
            localStorage.setItem('scrollPosition', 0);
        });
    });
</script>
