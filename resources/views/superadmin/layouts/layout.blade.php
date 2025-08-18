<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('superadmin_title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('images/loho.png') }}" type="image/x-icon" />

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
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('resource/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resource/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resource/css/kaiadmin.min.css') }}">

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">

                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('images/loho.png') }}" alt="navbar brand" class="navbar-brand rounded-circle"
                            height="48">
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>

                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item {{ request()->routeIs('superadmin') ? 'active' : '' }}">
                            <a href="{{ route('superadmin') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('superadmin.admins*') ? 'active' : '' }}">
                            <a href="{{ route('superadmin.admins') }}">
                                <i class="fas fa-user"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('superadmin.pasiens*') ? 'active' : '' }}">
                            <a href="{{ route('superadmin.pasiens') }}">
                                <i class="fas fa-th-list"></i>
                                <p>Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('superadmin.videos*') ? 'active' : '' }}">
                            <a href="{{ route('superadmin.videos.index') }}">
                                <i class="fas fa-video"></i>
                                <p>Video Latihan</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('superadmin.foundations*') ? 'active' : '' }}">
                            <a href="{{ route('superadmin.foundations.index') }}">
                                <i class="fas fa-building"></i>
                                <p>Manajemen Yayasan</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">

                        <a href="index.html" class="logo">
                            <img src="{{ asset('images/loho.png') }}" alt="navbar brand"
                                class="navbar-brand rounded-circle" height="48">
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>

                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="@if (auth()->user()->profile_photo_path) {{ asset('storage/' . auth()->user()->profile_photo_path) }}@else{{ asset('resource/img/profile.jpg') }} @endif"
                                            alt="Profile Photo" class="avatar-img rounded-circle">
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span> <span
                                            class="fw-bold">{{ auth()->user()->name }}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg"><img
                                                        src="@if (auth()->user()->profile_photo_path) {{ asset('storage/' . auth()->user()->profile_photo_path) }}@else{{ asset('superadmin/img/profile.jpg') }} @endif"
                                                        alt="image profile" class="avatar-img rounded"></div>
                                                <div class="u-text">
                                                    <h4>{{ auth()->user()->name }}</h4>
                                                    <p class="text-muted">{{ auth()->user()->email }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Account
                                                Setting</a>
                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <input type="submit" value="Logout" class="dropdown-item">
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">@yield('superadmin_page_title')</h3>
                        </div>
                    </div>
                    <div class="row row-card-no-pd">
                        @yield('superadmin_layout')
                    </div>

                </div>
            </div>

            {{-- <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright ms-auto">
                        2025, made with <i class="fa fa-heart heart text-danger"></i> by <a href="#!">GeriatricCare</a>
                    </div>				
                </div>
            </footer> --}}
        </div>


    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('resource/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('resource/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('resource/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('resource/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('resource/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('resource/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('resource/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('resource/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('resource/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('resource/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('resource/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('resource/js/kaiadmin.min.js') }}"></script>

    <!-- Initialize DataTables search and length controls -->
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({
                dom: 'lfrtip',
                paging: true,
                searching: true,
                info: true,
                lengthChange: true
            });
        });
    </script>
</body>

</html>
