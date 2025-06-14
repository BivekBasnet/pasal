<div id="sidebarMenuMobile" class="sidebar p-3 shadow bg-light d-md-none">
    <h4 class="mb-4"></h4>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebarMenuMobile');
    const toggleBtn = document.getElementById('sidebarToggle');
    function handleSidebar() {
        if (!sidebar) return;
        if (window.innerWidth < 768) {
            sidebar.classList.remove('active'); // Always start hidden on mobile
        } else {
            sidebar.classList.remove('active'); // Always visible on desktop
        }
    }
    handleSidebar();
    window.addEventListener('resize', handleSidebar);
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            if (!sidebar) return;
            sidebar.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                toggleBtn.innerText = '✖ Close';
            } else {
                toggleBtn.innerText = '☰ Menu';
            }
        });
    }
});
</script>
<style>
#sidebarMenuMobile {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    height: 100vh;
    background: #f8f9fa;
    transition: transform 0.3s ease;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
    position: fixed;
    left: 0;
    top: 0;
    transform: translateX(-100%);
    z-index: 1050;
}
#sidebarMenuMobile.active {
    transform: translateX(0);
    z-index: 1050;
}
@media (min-width: 768px) {
    #sidebarMenuMobile {
        display: none !important;
    }
}
</style>
