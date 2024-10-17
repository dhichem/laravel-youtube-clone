<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')

        <title>Youtube Clone</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        @yield('styles')
    </head>
    <body>

        @include('_includes/header/header')

        @yield('content')

        @yield('scripts')

    </body>
</html>

<script>
    window.AuthUser = @json(auth()->user());

    window.__auth = function() {
        return window.AuthUser || null;
    }
</script>