<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title></title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>



    </head>
        <body>
            <!--Inclui o menu principal no topo-->
            @include('layouts.menuprincipal')

            <!--Carrega configurações de estilo-->
            @yield('content')

                        <!-- JAVASCRIPT -->
                        <script src="{{ URL::asset('/libs/jquery/jquery.min.js')}}"></script>
                        <script src="{{ URL::asset('/libs/bootstrap/bootstrap.min.js')}}"></script>
                        <script src="{{ URL::asset('/libs/metismenu/metismenu.min.js')}}"></script>
                        <script src="{{ URL::asset('/libs/simplebar/simplebar.min.js')}}"></script>
                        <script src="{{ URL::asset('/libs/node-waves/node-waves.min.js')}}"></script>
                        <script src="{{ URL::asset('/libs/jquery-sparkline/jquery-sparkline.min.js')}}"></script>
                        <link rel="stylesheet" href="css/bootstrap.min.css" />
                        <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />



                        <!-- footerScript -->
                         @yield('footerScript')

                        <!-- App js -->
                        <script src="{{ URL::asset('/js/app.min.js')}}"></script>

        </body>
</html>
