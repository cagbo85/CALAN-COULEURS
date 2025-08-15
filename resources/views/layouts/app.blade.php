<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Meta tags dynamiques --}}
    @yield('meta')

    {{-- Scripts et styles communs --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/logos/TOUCAN.png') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'urbanist': ['Urbanist', 'sans-serif'],
                        'urbanist-bold': ['Urbanist Bold', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    @viteReactRefresh
    {{-- @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx', 'resources/js/timer-loader.jsx', 'resources/js/onsite-loader.jsx', 'resources/js/faq-loader.jsx']) --}}
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx'])

    {{-- Scripts additionnels par page --}}
    @stack('scripts')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Titre dynamique --}}
    <title>@yield('title', 'Calan\'Couleurs Festival 2025')</title>
</head>

<body class="w-full">
    {{-- Navbar commune --}}
    <header class="sticky top-0 z-10 bg-white">
        @include('partials.navbar')
    </header>

    {{-- Contenu principal --}}
    <main class="w-full">
        @yield('content')
    </main>

    {{-- Footer commun --}}
    @include('partials.footer')

    {{-- Scripts additionnels en fin de page --}}
    @stack('scripts-footer')
</body>

</html>
