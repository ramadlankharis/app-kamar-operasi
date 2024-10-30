<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('dashboard-admin/css/font-face.css')}} " rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/font-awesome-4.7/css/font-awesome.min.css')}} " rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/font-awesome-5/css/fontawesome-all.min.css')}} " rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/mdi-font/css/material-design-iconic-font.min.css')}} " rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('dashboard-admin/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('dashboard-admin/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard-admin/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('dashboard-admin/css/theme.css')}}" rel="stylesheet" media="all">

    @stack('styles')

</head>

<body class="animsition">
    <div class="page-wrapper">
        {{-- Header Mobile --}}
            @include('components.admin.header-mobile')
        {{-- Header Mobile --}}
        <!-- MENU SIDEBAR-->
            @include('components.admin.menu-sidebar')
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
           @include('components.admin.header-desktop')
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">

                        @yield('content')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2024 MIA. All rights reserved. Template by.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    {{-- <script src="{{asset('dashboard-admin/vendor/jquery-3.2.1.min.js')}}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS-->
    <script src="{{asset('dashboard-admin/vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('dashboard-admin/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="{{asset('dashboard-admin/vendor/slick/slick.min.js')}}">
    </script>
    <script src="{{asset('dashboard-admin/vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('dashboard-admin/vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{asset('dashboard-admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
    </script>
    <script src="{{asset('dashboard-admin/vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('dashboard-admin/vendor/counter-up/jquery.counterup.min.js')}}">
    </script>
    <script src="{{asset('dashboard-admin/vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('dashboard-admin/vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('dashboard-admin/vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('dashboard-admin/vendor/select2/select2.min.js')}}"></script>

    <!-- Main JS-->
    <script src="{{asset('dashboard-admin/js/main.js')}}"></script>

    @stack('scripts')

</body>

</html>
<!-- end document-->