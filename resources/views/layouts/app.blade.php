<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @yield('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


     @yield('style')


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
   

    <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" /> -->

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->


    <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->


    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body>

    <!--Inclui o menu principal no topo-->
    @include('layouts.menuprincipal')

    <!--Carrega configurações de estilo-->
    @yield('content')

    @include('flash::message')
    <!-- JAVASCRIPT -->

    <!-- footerScript -->
    @yield('footerScript')



</body>

    <script>
        $("body").on("submit", "form", function() {
            $(this).submit(function() {
                return false;
            });
            $(':submit').html(
                '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Carregando...')
            return true;
        });
    </script>

</html>
