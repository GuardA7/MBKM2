<nav class="sb-topnav navbar navbar-expand-lg navbar-light bg-light shadow">

    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3 text-black d-flex align-items-center">
        <img src="{{ asset('img/16.png') }}" alt="Logo" width="30" height="30"
            class="d-inline-block align-text-top">
        <small class="d-inline-block ms-2 fs-7 text-wrap" style="font-size: 10px;">
            Sistem Informasi Layanan Pelatihan <br> dan Uji Kompetensi
        </small>
    </a>

    <!-- Sidebar Toggle for smaller screens -->
    <button class="d-flex btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>

    <!-- Navbar profile -->
    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#">
                <!-- Profile Icon -->
                <span>{{ Auth::user()->nama }}</span>
                <i class="fas fa-user-circle fa-lg"></i>
            </a>
        </li>
    </ul>
</nav>
