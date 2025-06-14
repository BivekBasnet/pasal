<div id="sidebarMenu" class="sidebar p-3 shadow bg-light">
    <h4 class="mb-4 text-center fw-bold bkp-title">
    <a href="{{ route('home') }}" class="text-decoration-none text-dark">BKP</a>
</h4>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{ route('customers.add') }}">➕ Add New Customer</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{ route('transictions.add') }}">🛒 Add Purchase</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{ route('customers.list') }}">👥 Customer List</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{ route('transictions.list') }}">📦 Purchases List</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{ route('customer.purchases') }}">🧾 Customer Purchases</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{ route('transictions.day') }}">📅 Day Purchase</a>
        </li>
    </ul>
</div>

<style>
.bkp-title a {
    cursor: pointer;
    transition: color 0.3s ease;
}

.bkp-title a:hover {
    color: #0d6efd !important;
}

#sidebarMenu {
    width: 280px;
    height: 100vh;
    background: #f8f9fa;
    transition: all 0.3s ease;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
}

@media (min-width: 768px) {
    #sidebarMenu {
        position: sticky;
        top: 0;
    }
}

@media (max-width: 767.98px) {
    #sidebarMenu {
        position: fixed;
        left: 0;
        top: 30px;
        transform: translateX(-100%);
        z-index: 1050;
    }

    #sidebarMenu.active {
        transform: translateX(0);
    }
}

.nav-link {
    color: #333;
    transition: all 0.3s;
    padding: 0.75rem 1rem;
    display: block;
    text-decoration: none;
}

.nav-link:hover {
    background: #e9ecef;
    border-radius: 5px;
    color: #000;
}

.active .nav-link {
    background: #e9ecef;
    border-radius: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebarMenu');
    const toggleBtn = document.getElementById('sidebarToggle');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function(event) {
            event.stopPropagation();
            sidebar.classList.toggle('active');
            toggleBtn.innerText = sidebar.classList.contains('active') ? '✖ Close' : '☰ Menu';
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 768
            && sidebar
            && sidebar.classList.contains('active')
            && !sidebar.contains(event.target)
            && event.target !== toggleBtn) {
            sidebar.classList.remove('active');
            if (toggleBtn) {
                toggleBtn.innerText = '☰ Menu';
            }
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 768 && sidebar) {
                sidebar.classList.remove('active');
                if (toggleBtn) {
                    toggleBtn.innerText = '☰ Menu';
                }
            }
        }, 250);
    });
});
</script>
