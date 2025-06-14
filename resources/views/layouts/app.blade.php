<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Bijay Kirana Pasal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script> @yield('jssss') </script>
    <style>
        body {
            overflow-x: hidden;
        }
        .main-wrapper {
            min-height: 100vh;
        }
        @yield('css')
    </style>
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
        <button id="sidebarToggle" class="btn btn-primary d-md-none m-2" style="position: fixed; top: 20px; left: 20px; z-index: 1100;">☰ Menu</button>

        <div class="main-wrapper">
            <div class="d-flex">
                <!-- Sidebar -->
                @include('sidebar')

                <!-- Main Content -->
                <div class="flex-grow-1 p-3">
                    @yield('content')
                </div>
            </div>
        </div>

        @if (!in_array(Route::currentRouteName(), ['login', 'register']))
            <form action="{{ route('logout') }}" method="POST" style="position: fixed; top: 20px; right: 30px; z-index: 999;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        @endif
    @endif
    @stack('scripts')
</body>
</html>
