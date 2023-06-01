<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @yield('head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title></title>

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <!--Fonts-->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])


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

                        <script src="{{ URL::asset('/libs/jquery-sparkline/jquery-sparkline.min.js')}}"></script>

                        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>



                        <!-- footerScript -->
                         @yield('footerScript')

                        <!-- App js -->
                        <script src="{{ URL::asset('/js/app.min.js')}}"></script>

        </body>
</html>
