<div id="sidebarMenu" class="sidebar p-3 bg-light">
    <h4 class="mb-4 text-center fw-bold bkp-title">
        <a href="{{ route('home') }}" class="text-decoration-none text-dark">BKP</a>
    </h4>

    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('customers.add') ? 'active' : '' }}"
               href="{{ route('customers.add') }}">
                <span class="nav-icon">➕</span>
                <span class="ms-2">Add New Customer</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('transictions.add') ? 'active' : '' }}"
               href="{{ route('transictions.add') }}">
                <span class="nav-icon">🛒</span>
                <span class="ms-2">Add Purchase</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('customers.list') ? 'active' : '' }}"
               href="{{ route('customers.list') }}">
                <span class="nav-icon">👥</span>
                <span class="ms-2">Customer List</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('transictions.list') ? 'active' : '' }}"
               href="{{ route('transictions.list') }}">
                <span class="nav-icon">📦</span>
                <span class="ms-2">Purchases List</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('customer.purchases') ? 'active' : '' }}"
               href="{{ route('customer.purchases') }}">
                <span class="nav-icon">🧾</span>
                <span class="ms-2">Customer Purchases</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('transictions.day') ? 'active' : '' }}"
               href="{{ route('transictions.day') }}">
                <span class="nav-icon">📅</span>
                <span class="ms-2">Day Purchase</span>
            </a>
        </li>
    </ul>
</div>

<style>
.sidebar {
    width: 280px;
    height: 100vh;
    transition: all 0.3s ease;
    box-shadow: 2px 0 5px rgba(0,0,0,0.05);
}

.bkp-title {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.bkp-title a {
    font-size: 1.5rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.bkp-title a:hover {
    color: #6f42c1 !important;
}

.nav-link {
    color: #495057;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease-in-out;
}

.nav-link:hover {
    background-color: #f8f9fa;
    color: #6f42c1;
    transform: translateX(5px);
}

.nav-link.active {
    background-color: #6f42c1;
    color: white !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.nav-icon {
    font-size: 1.25rem;
    width: 24px;
    text-align: center;
}

@media (min-width: 768px) {
    .sidebar {
        position: sticky;
        top: 0;
    }
}

@media (max-width: 767.98px) {
    .sidebar {
        position: fixed;
        left: -280px;
        top: 0;
        z-index: 1050;
        transform: translateX(0);
        transition: transform 0.3s ease-in-out;
        height: 100%;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .sidebar.active {
        transform: translateX(280px);
    }

    .nav-link {
        padding: 1rem;
    }

    .nav-icon {
        font-size: 1.5rem;
    }
}
</style>
