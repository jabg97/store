<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">


    <title>@yield('template_title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/font-awesome.all.css') }}" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard/scroll.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/navbar-custom.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/navbar-custom-themes.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}" type="text/css">
    <style type="text/css">
        body {
            background-color: #eceff1;
        }

        .sidebar-bg.bg1 .sidebar-wrapper {
            background-image: url("{{ asset('img/dashboard/sidebar/bg1.jpg')}}");
        }

    </style>
    @yield('css_links')
    @laravelPWA
</head>

<body>
    <div id="loading" class="se-pre-con"></div>
    <div id="float-menu" class="float-menu"></div>
    @yield('main')
    <script type="text/javascript" src="{{ asset('js/addons/moment.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/font-awesome.all.js') }}"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dashboard/scroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dashboard/navbar-custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @include('sweetalert::alert')
    @yield('js_links')
    <script type="text/javascript">
        $(document).ready(function () {
            
            syncPlaceToPay();
            setInterval(syncPlaceToPay, 1000*60);

            function syncPlaceToPay() {
                $.ajax({
                    method: "GET",
                    url: "{{ route('p2p.sync') }}",
                    async: true
                })
                .done(function (response) {
                try {
                    console.log(response);
                } catch (err) {
                    console.log(err.message);
                }
            })
            .fail(function (response) {
                console.log(response);
            })
            .always(function () {
                fin_carga();
            });
                console.log('OK');
            }
        });

    </script>
</body>

</html>
