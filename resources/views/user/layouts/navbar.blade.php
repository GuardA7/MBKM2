<nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary shadow">
    <!-- Sidebar Toggle (Burger Button) -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-2" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Brand (Logo) -->
    <a class="navbar-brand ps-2" href="/index">
        <img src="https://tikom.polindra.ac.id/wp-content/uploads/2024/06/group_1_3x.webp" alt="Upa Polindra" style="width: auto; max-height: 40px;">
    </a>

    <!-- Spacer to push notifications and profile to the end -->
    <div class="ms-auto"></div>

    <!-- Notification and Profile Menu -->
    <ul class="navbar-nav align-items-center p-2">

        <!-- Notification Button -->
        <li class="nav-item dropdown me-3">
            <a class="nav-link" id="notificationDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Badge to show number of notifications -->
                <span class="badge bg-danger">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                <li><a class="dropdown-item" href="#!">No new notifications</a></li>
                <!-- Additional notification items here -->
            </ul>
        </li>

        <!-- Profile Button -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end me-2" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.user') }}">Profile</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <form action="{{ route('logout') }}" method="get">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
