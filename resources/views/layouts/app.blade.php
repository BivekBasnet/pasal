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
            min-height: 100vh;
        }
        .main-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }
        @media (max-width: 767.98px) {
            .main-content {
                padding-top: 60px;
            }
            .content-center {
                min-height: calc(100vh - 80px);
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card {
                width: 100%;
                margin: 1rem;
            }
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }
        @yield('css')
    </style>
</head>
<body>
    @if (in_array(Route::currentRouteName(), ['login', 'register']))
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center min-vh-100">
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
                <div class="content-wrapper">
                    <div class="main-content">
                        <div class="content-center">
                            @yield('content')
                        </div>
                    </div>
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
</body>
</html>
