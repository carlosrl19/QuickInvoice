<!DOCTYPE html>
<html lang="es" translate="no">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ Storage::url('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ Storage::url('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ Storage::url('assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ Storage::url('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ Storage::url('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ Storage::url('assets/css/kaiadmin.min.css') }}" />
    @yield('head')
</head>

<body>
    <div class="wrapper">
        <div id="spinner" style="position: fixed; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6);
            z-index: 9999; display: flex; justify-content: center; align-items: center;">
            <div class="spinner-border text-white" role="status" style="width: 3rem; height: 3rem;">
            </div>
            <span class="text-white fw-bold">&nbsp; Cargando...</span>
        </div>
        <!-- Sidebar -->
        @include('layouts._sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    @include('layouts._logo_header')
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                @include('layouts._navbar')
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <div class="page-header">
                                <h3 class="fw-bold mb-1">@yield('title')</h3>
                                @yield('breadcrumb')
                            </div>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            @yield('create')
                        </div>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                        <p class="text-danger fw-bold">
                            <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: red" />&nbsp;
                            Error al completar acción. Intente nuevamente.
                        </p>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
        <!-- End Custom template -->
    </div>

    <!--   Core JS Files   -->
    <script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ Storage::url('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ Storage::url('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ Storage::url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ Storage::url('assets/js/kaiadmin.min.js') }}"></script>

    <!-- Spinner -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("spinner").style.display = "none";
        });
    </script>

    @yield('scripts')
</body>

</html>