<!DOCTYPE html>
<html lang="id">

    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>@yield('foundation_title') - {{ $foundation->name ?? 'Yayasan' }}</title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link rel="icon" href="{{ asset('images/loho.png') }}" type="image/x-icon" />

        @php
            // Ensure foundation variable exists
            if (!isset($foundation)) {
                if (Auth::check() && Auth::user()->foundation) {
                    $foundation = Auth::user()->foundation;
                } else {
                    $foundation = (object) ['name' => 'Yayasan'];
                }
            }
        @endphp

        <!-- Fonts and icons -->
        <script src="{{ asset('resource/js/plugin/webfont/webfont.min.js') }}"></script>
        <script>
            WebFont.load({
                google: {
                    "families": ["Public Sans:300,400,500,600,700"]
                },
                custom: {
                    "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                        "simple-line-icons"
                    ],
                    urls: ['{{ asset('resource/css/fonts.min.css') }}']
                },
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
        </script>

        <!-- CSS Files -->
        <link rel="stylesheet" href="{{ asset('resource/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('resource/css/plugins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('resource/css/kaiadmin.min.css') }}">

        <style>
            /* Tab Navigation Styling - Force visibility */
            .nav-tabs {
                display: flex !important;
                flex-direction: row !important;
                list-style: none !important;
                margin: 0 !important;
                padding: 0 20px !important;
                background-color: #f8f9fa !important;
                border-bottom: 2px solid #e9ecef !important;
                position: relative !important;
                z-index: 1000 !important;
                height: auto !important;
                overflow: visible !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .nav-tabs .nav-item {
                display: block !important;
                margin-right: 5px !important;
                list-style: none !important;
            }

            .nav-tabs .nav-link {
                display: block !important;
                padding: 15px 20px !important;
                text-decoration: none !important;
                color: #6c757d !important;
                background-color: transparent !important;
                border: none !important;
                border-radius: 8px 8px 0 0 !important;
                transition: all 0.3s ease !important;
                cursor: pointer !important;
                font-weight: 500 !important;
            }

            .nav-tabs .nav-link:hover {
                color: #495057 !important;
                background-color: #e9ecef !important;
                text-decoration: none !important;
            }

            .nav-tabs .nav-link.active {
                color: #007bff !important;
                background-color: #fff !important;
                border: 2px solid #007bff !important;
                border-bottom: 2px solid #fff !important;
                margin-bottom: -2px !important;
                font-weight: 600 !important;
            }

            .nav-tabs .nav-link i {
                margin-right: 8px !important;
            }

            /* Content area styling */
            .main-content {
                background-color: #f8f9fa;
                min-height: calc(100vh - 200px);
                padding: 20px 0;
            }

            /* Card styling improvements */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            .card-header {
                background-color: #fff;
                border-bottom: 1px solid #e9ecef;
                border-radius: 12px 12px 0 0 !important;
            }

            /* Tab content styling */
            .tab-content {
                padding: 20px 0;
            }

            /* Table improvements */
            .table {
                margin-bottom: 0;
            }

            .table th {
                border-top: none;
                font-weight: 600;
                color: #495057;
                background-color: #f8f9fa;
            }

            .table td {
                vertical-align: middle;
            }

            /* Badge improvements */
            .badge {
                font-size: 0.75em;
                padding: 0.5em 0.75em;
            }

            /* Button improvements */
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
                border-radius: 0.375rem;
            }

            /* Responsive improvements */
            @media (max-width: 768px) {
                .nav-tabs {
                    padding: 0 10px;
                }

                .nav-tabs .nav-link {
                    padding: 10px 15px;
                    font-size: 0.9rem;
                }

                .main-content {
                    padding: 15px;
                }
            }

            /* Ensure tab navigation is visible */
            #foundationTabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                overflow: visible !important;
                position: relative !important;
                z-index: 1000 !important;
            }

            /* Hide pasiens content by default */
            #pasiens-content {
                display: none !important;
            }

            /* Show dashboard content by default */
            #dashboard-content {
                display: block !important;
            }

            /* Debug styling */
            .debug-info {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                padding: 10px;
                margin: 10px 0;
                border-radius: 5px;
                font-family: monospace;
                font-size: 12px;
            }

            /* Override any conflicting styles */
            .main-content .nav-tabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                overflow: visible !important;
            }

            /* Force all nav-tabs to be visible */
            .nav.nav-tabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* Ensure tab container is visible */
            .container-fluid .nav-tabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* Additional specificity for tab navigation */
            div.container-fluid div.row div.col-md-12 ul.nav.nav-tabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                overflow: visible !important;
            }

            /* Force tab navigation container to be visible */
            #foundationTabs.nav.nav-tabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                overflow: visible !important;
                position: relative !important;
                z-index: 1000 !important;
            }

            /* Ensure tab items are visible */
            #foundationTabs .nav-item {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* Ensure tab links are visible */
            #foundationTabs .nav-link {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* Override any potential CSS conflicts */
            .main-panel .container-fluid .nav-tabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* Force visibility with maximum specificity */
            body .wrapper .main-panel .container-fluid .row .col-md-12 .nav.nav-tabs {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                overflow: visible !important;
            }
        </style>
    </head>

    <body>
        <div class="wrapper d-flex" style="min-height:100vh;">
            <!-- Sidebar -->
            <div class="sidebar sidebar-style-2" id="foundationSidebar" data-background-color="dark">
                <div class="sidebar-logo text-center py-3">
                    <a href="{{ route('foundation.dashboard') }}" class="logo">
                        <img src="{{ asset('images/loho.png') }}" alt="navbar brand" class="navbar-brand rounded-circle"
                            height="48">
                    </a>
                </div>
                <div class="sidebar-wrapper scrollbar scrollbar-inner">
                    <div class="sidebar-content">
                        <ul class="nav nav-secondary">
                            <li class="nav-item {{ request()->routeIs('foundation.dashboard') ? 'active' : '' }}">
                                <a href="{{ route('foundation.dashboard') }}">
                                    <i class="fas fa-home"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('foundation.pasiens.create') ? 'active' : '' }}">
                                <a href="{{ route('foundation.pasiens.create') }}">
                                    <i class="fas fa-plus"></i>
                                    <p>Tambah Pasien</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('home') }}" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                    <p>Halaman Publik</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-link nav-link d-flex align-items-center gap-2 p-0"
                                        style="background: none; border: none; width: 100%; text-align: left; font-size:1rem;">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span style="margin:0; padding:0; font-weight:500; color:#1976d2;">Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Sidebar -->

            <div class="main-panel flex-grow-1" id="foundationMainPanel" style="margin-left:250px;">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white">
                    <div class="container-fluid">
                        <div class="navbar-wrapper">
                            <div class="container-fluid px-4">
                                <div class="d-flex align-items-center justify-content-between w-100"
                                    style="min-height:64px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <button id="sidebarToggle" class="btn btn-outline-primary me-3"
                                            style="font-size:1.3rem;">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                        <h4 class="navbar-title mb-0" style="font-size:1.35rem;">
                                            @yield('foundation_page_title')</h4>
                                    </div>
                                    <ul class="navbar-nav flex-row align-items-center" style="gap:10px;">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                                id="navbarDropdown" role="button" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-building me-2"></i> <span
                                                    style="font-weight:500;">{{ $foundation->name ?? 'Yayasan' }}</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('foundation.dashboard') }}">
                                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-sign-out-alt"></i> Logout
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tab Navigation -->
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="nav nav-tabs" id="foundationTabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link {{ request()->routeIs('foundation.dashboard') ? 'active' : '' }}"
                                                        id="dashboard-tab" href="{{ route('foundation.dashboard') }}"
                                                        role="tab" aria-controls="dashboard"
                                                        aria-selected="{{ request()->routeIs('foundation.dashboard') ? 'true' : 'false' }}">
                                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link {{ request()->routeIs('foundation.pasiens*') ? 'active' : '' }}"
                                                        id="pasiens-tab" href="{{ route('foundation.pasiens') }}"
                                                        role="tab" aria-controls="pasiens"
                                                        aria-selected="{{ request()->routeIs('foundation.pasiens*') ? 'true' : 'false' }}">
                                                        <i class="fas fa-users"></i> Data Pasien
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Content -->
                                <div class="main-content mt-4">
                                    <div class="container-fluid">
                                        @yield('foundation_layout')
                                    </div>
                                </div>

                                <!-- Footer -->
                                <footer class="footer">
                                    <div class="container-fluid">
                                        <div class="copyright">
                                            © 2025 Sistem Informasi Geriatric Care -
                                            {{ $foundation->name ?? 'Yayasan' }}
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </div>

                        <!-- Core JS Files -->
                        <script src="{{ asset('resource/js/core/jquery.3.2.1.min.js') }}"></script>
                        <script src="{{ asset('resource/js/core/popper.min.js') }}"></script>
                        <script src="{{ asset('resource/js/core/bootstrap.min.js') }}"></script>

                        <!-- jQuery UI -->
                        <script
                            src="{{ asset('resource/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
                        <script
                            src="{{ asset('resource/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

                        <!-- jQuery Scrollbar -->
                        <script
                            src="{{ asset('resource/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

                        <!-- Chart JS -->
                        <script src="{{ asset('resource/js/plugin/chart.js/chart.min.js') }}"></script>

                        <!-- jQuery Sparkline -->
                        <script
                            src="{{ asset('resource/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

                        <!-- Chart Circle -->
                        <script src="{{ asset('resource/js/plugin/chart-circle/circles.min.js') }}"></script>

                        <!-- Datatables -->
                        <script src="{{ asset('resource/js/plugin/datatables/datatables.min.js') }}"></script>

                        <!-- Bootstrap Notify -->
                        <script
                            src="{{ asset('resource/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

                        <!-- Sweet Alert -->
                        <script src="{{ asset('resource/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

                        <!-- Atlantis JS -->
                        <script src="{{ asset('resource/js/atlantis.min.js') }}"></script>

                        @stack('scripts')

                        <script>
                            // Sidebar toggle logic
                            document.addEventListener('DOMContentLoaded', function () {
                                var sidebar = document.getElementById('foundationSidebar');
                                var mainPanel = document.getElementById('foundationMainPanel');
                                var sidebarToggle = document.getElementById('sidebarToggle');
                                // Function hanya dijalankan saat tombol sidebar diklik
                                sidebarToggle.addEventListener('click', function () {
                                    var isClosed = sidebar.classList.toggle('sidebar-closed');
                                    if (isClosed) {
                                        mainPanel.classList.add('main-panel-full');
                                    } else {
                                        mainPanel.classList.remove('main-panel-full');
                                    }
                                });
                            });
                        </script>
                        <style>
                            .navbar {
                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
                                min-height: 64px;
                            }

                            .navbar-title {
                                font-size: 1.35rem;
                                font-weight: 600;
                                color: #222;
                            }

                            .navbar-nav .nav-link {
                                font-size: 1rem;
                                color: #222;
                            }

                            .navbar-nav .nav-link .fa-building {
                                margin-right: 6px;
                            }

                            .navbar-nav .dropdown-menu {
                                min-width: 180px;
                            }

                            @media (max-width: 991px) {
                                .navbar-title {
                                    font-size: 1.1rem;
                                }

                                .navbar {
                                    min-height: 56px;
                                }
                            }

                            .wrapper {
                                min-height: 100vh;
                            }

                            .sidebar {
                                position: fixed;
                                left: 0;
                                top: 0;
                                width: 250px;
                                height: 100vh;
                                z-index: 1050;
                                transition: width 0.3s;
                            }

                            .sidebar-closed {
                                width: 60px !important;
                                transition: width 0.3s;
                            }

                            .main-panel {
                                margin-left: 250px;
                            }

                            .main-panel-full {
                                margin-left: 60px !important;
                                transition: margin-left 0.3s;
                            }

                            @media (max-width: 991px) {
                                .sidebar {
                                    left: 0;
                                    width: 220px;
                                }

                                .sidebar-closed {
                                    left: -220px !important;
                                    width: 220px !important;
                                }

                                .main-panel,
                                .main-panel-full {
                                    margin-left: 0 !important;
                                }
                            }
                        </style>
    </body>

</html>