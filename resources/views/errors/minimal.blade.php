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
    {{-- @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx', 'resources/js/timer-loader.jsx', 'resources/js/stands-loader.jsx', 'resources/js/faq-loader.jsx']) --}}
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx'])

    {{-- Scripts additionnels par page --}}
    @stack('scripts')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Titre dynamique --}}
    <title>@yield('title', 'Calan\'Couleurs Festival 2025')</title>
</head>

<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center px-4"
        style="background: linear-gradient(135deg, #8F1E98 0%, #FF0F63 50%, #272AC7 100%);">
        <div class="text-center">
            <!-- Logo -->
            <div class="mb-8">
                <img src="{{ asset('img/logos/LOGO/Logo-Calan-blanc.png') }}" alt="Calan'Couleurs"
                    class="h-32 mx-auto mb-6">
            </div>

            <!-- Code d'erreur -->
            <h1 class="text-8xl font-bold text-white mb-4">
                @yield('code')
            </h1>

            <!-- Titre de l'erreur -->
            <h2 class="text-3xl font-bold text-white mb-6">
                @yield('error_title')
            </h2>

            <!-- Message personnalisé -->
            <p class="text-xl text-white/90 mb-8 max-w-md mx-auto">
                @yield('message')
            </p>

            <!-- Boutons d'action -->
            <div class="space-y-4">
                @yield('actions')
            </div>

            <!-- Message additionnel -->
            @hasSection('additional_message')
                <div class="mt-12 text-white/70">
                    <p class="text-sm">@yield('additional_message')</p>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
