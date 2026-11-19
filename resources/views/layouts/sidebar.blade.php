<style>
    .sidebar-custom .menu-item {
        display: flex;
        align-items: center;
        color: #cbd5e1;
        text-decoration: none;
        padding: 10px 14px;
        border-radius: 8px;
        transition: background-color 0.2s, color 0.2s;
    }

    .sidebar-custom .menu-item:hover {
        background-color: rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }

    .sidebar-custom .menu-item.active {
        background-color: #0d6efd;
        color: #ffffff;
        font-weight: 600;
    }

    .sidebar-custom .dropdown-item-custom {
        display: block;
        padding: 8px 12px;
        color: #e2e8f0;
        text-decoration: none;
        border-radius: 6px;
    }

    .sidebar-custom .dropdown-item-custom:hover {
        background-color: rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }
</style>

<div class="d-flex flex-column flex-shrink-0 p-3 sidebar-custom"
    style="width: 260px; min-height: 100vh; background-color: #212529; color: #ffffff;">

    <!-- Logo -->
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 text-decoration-none" style="color: #ffffff;">
        <i class="bi bi-car-front-fill me-2" style="font-size: 1.75rem;"></i>
        <span class="fw-bold" style="font-size: 1.5rem;">Rental Mobil</span>
    </a>

    <hr style="border-color: rgba(255,255,255,0.2);">

    <!-- Menu (Gunakan div/ul biasa tanpa class nav/nav-link bawaan BS6) -->
    <ul class="list-unstyled d-flex flex-column gap-1 mb-auto">

        <!-- Dashboard -->
        <li>
            <a href="/"
                class="menu-item {{ request()->is('/*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <!-- Data Mobil -->
        <li>
            <a href="/data-mobil"
                class="menu-item {{ request()->is('data-mobil*') ? 'active' : '' }}">
                <i class="bi bi-car-front me-2"></i>
                Data Mobil
            </a>
        </li>

        <!-- Data Pelanggan -->
        <li>
            <a href="/data-customer"
                class="menu-item {{ request()->is('data-customer*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>
                Data Pelanggan
            </a>
        </li>

        <!-- Data Rental -->
        <li>
            <a href="/data-rental"
                class="menu-item {{ request()->is('data-rental*') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-2"></i>
                Data Rental
            </a>
        </li>

        @if (auth()->user()->role == 'admin')
        <li>
            <a href="/pembayaran"
                class="menu-item {{ request()->is('pembayaran*') ? 'active' : '' }}">
                <i class="bi bi-credit-card me-2"></i>
                Pembayaran
            </a>
        </li>

        <!-- Laporan -->
        <li>
            <a href="/laporan"
                class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i>
                Laporan
            </a>
        </li>

        <li>
            <a href="/data-user"
                class="menu-item {{ request()->is('user*') ? 'active' : '' }}">
                <i class="bi bi-person me-2"></i>
                User
            </a>
        </li>

        @endif
        <!-- Pembayaran -->

    </ul>

    <hr style="border-color: rgba(255,255,255,0.2);">

    <!-- User -->
    <details class="position-relative">
        <summary class="d-flex align-items-center text-decoration-none" style="cursor: pointer; list-style: none; color: #ffffff;">
            <i class="bi bi-person-circle fs-4 me-2"></i>
            <strong class="me-auto">{{ auth()->user()->name }}</strong>
            <i class="bi bi-chevron-up small"></i>
        </summary>

        <ul class="list-unstyled rounded-2 p-2 shadow position-absolute bottom-100 start-0 w-100 mb-2"
            style="background-color: #2b3035; border: 1px solid rgba(255,255,255,0.15);">
            <li><a class="dropdown-item-custom" href="#">Profile</a></li>
            <li><a class="dropdown-item-custom" href="#">Pengaturan</a></li>
            <li>
                <hr style="margin: 6px 0; border-color: rgba(255,255,255,0.15);">
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item-custom w-100 text-start border-0 bg-transparent" style="color: #f87171;">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </details>
</div>