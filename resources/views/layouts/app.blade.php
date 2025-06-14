<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bijay Kirana Pasal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @if (in_array(Route::currentRouteName(), ['login', 'register']))
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6 p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-2 bg-light p-3" style="min-height: 100vh;">
                    @include('sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-md-9 p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    @endif

    @if (!in_array(Route::currentRouteName(), ['login', 'register']))
        <form action="{{ route('logout') }}" method="POST" style="position: absolute; top: 20px; right: 30px; z-index: 999;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @stack('scripts')
</body>
</html>
