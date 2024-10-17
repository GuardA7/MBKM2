<nav class="sb-topnav navbar navbar-expand navbar-dark  bg-primary  shadow">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/index">UPA POLINDRA</a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Spacer to push notifications and profile to the end -->
    <div class="ms-auto"></div>

    <!-- Notification Button -->
    <ul class="navbar-nav p-2">
        <li class="nav-item dropdown">
            <a class="nav-link" id="notificationDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Optional: Badge to show number of notifications -->
                <span class="badge bg-danger">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                <li><a class="dropdown-item" href="#!">No new notifications</a></li>
                <!-- Add more notification items here -->
            </ul>
        </li>

        <!-- Profile Button -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end me-2" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
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
