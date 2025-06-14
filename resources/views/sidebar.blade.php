<div class="sidebar p-3 shadow" style="width:250px; height:100vh; background-color:#f8f9fa; position:fixed;">
    <h4 class="mb-4">Pasal Menu</h4>
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
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{ route('details.index') }}">📋 Details</a>
        </li>
    </ul>
</div>
