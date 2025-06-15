<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            padding-top: 0 !important;
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
            width: 100%;
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }
        #sidebarToggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1100;
            padding: 8px 12px;
            border-radius: 4px;
            background-color: #6f42c1;
            color: white;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: none;
            font-size: 1.25rem;
            line-height: 1;
            cursor: pointer;
        }
        #sidebarToggle:hover {
            background-color: #5a32a3;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .overlay.show {
            opacity: 1;
        }
        @media (max-width: 767.98px) {
            #sidebarToggle {
                display: block;
            }
            .main-content {
                padding-top: 4rem;
            }
            .content-center {
                min-height: calc(100vh - 5rem);
            }
            .overlay.active {
                display: block;
            }
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }
        @yield('css')
    </style>
    @stack('css')
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
        <button type="button" id="sidebarToggle" aria-label="Toggle Sidebar">☰</button>
        <div class="overlay" id="sidebarOverlay"></div>

        <div class="main-wrapper">
            <div class="d-flex">
                <!-- Sidebar -->
                @include('sidebar')

                <!-- Main Content -->
                <div class="content-wrapper">
                    <div class="main-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        @if (!in_array(Route::currentRouteName(), ['login', 'register']))
            <form action="{{ route('logout') }}" method="POST" style="position: fixed; top: 1rem; right: 1rem; z-index: 999;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @endif
    @endif

    @stack('scripts')

    @if (!in_array(Route::currentRouteName(), ['login', 'register']))
    <script>
    $(document).ready(function() {
        const $sidebar = $('#sidebarMenu');
        const $toggle = $('#sidebarToggle');
        const $overlay = $('#sidebarOverlay');

        function toggleSidebar() {
            $sidebar.toggleClass('active');
            $overlay.toggleClass('active');
            if ($sidebar.hasClass('active')) {
                $toggle.html('✖');
                setTimeout(() => $overlay.addClass('show'), 50);
            } else {
                $toggle.html('☰');
                $overlay.removeClass('show');
            }
        }

        $toggle.on('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });

        $overlay.on('click', function() {
            toggleSidebar();
        });

        $(document).on('click', function(e) {
            if ($(window).width() < 768 &&
                $sidebar.hasClass('active') &&
                !$(e.target).closest('#sidebarMenu').length &&
                !$(e.target).closest('#sidebarToggle').length) {
                toggleSidebar();
            }
        });

        $(window).on('resize', function() {
            if ($(window).width() >= 768 && $sidebar.hasClass('active')) {
                $sidebar.removeClass('active');
                $overlay.removeClass('active show');
                $toggle.html('☰');
            }
        });
    });
    </script>
    @endif
</body>
</html>
