<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @yield('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>



    <!-- Scripts -->
    @vite(['resources/sass/app.scss',
            'resources/js/app.js'])

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


    <!-- App js -->
    <script src="{{ URL::asset('/js/app.min.js') }}"></script>
    <!--JQUERY-->

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
