<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

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
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx', 'resources/js/timer-loader.jsx', 'resources/js/onsite-loader.jsx', 'resources/js/faq-loader.jsx', 'resources/js/program-loader.jsx'])

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>CALAN-COULEURS</title>
</head>

<body class="flex flex-col h-screen">
    <div id="navbar-root" data-home-url="{{ url('/') }}" data-programmation-url="{{ url('/programmation') }}"
        data-billetterie-url="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs">
    </div>
    <div class="flex-grow overflow-auto">
        @yield('content')
    </div>
    @include('partials.footer')
</body>

</html>
