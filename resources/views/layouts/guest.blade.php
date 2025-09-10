<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx', 'resources/js/timer-loader.jsx', 'resources/js/stands-loader.jsx', 'resources/js/faq-loader.jsx', 'resources/js/program-loader.jsx', 'resources/js/app.js'])

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>CALAN-COULEURS - Administration</title>
    <link rel="icon" type="image/png" href="/img/logos/TOUCAN.png">
</head>

<body class="font-urbanist antialiased min-h-screen"
    style="background: linear-gradient(135deg, rgba(39,42,199,0.9) 0%, rgba(143,30,152,0.9) 50%, rgba(255,15,99,0.9) 100%);">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="mb-8">
            <a href="/">
                <img src="/img/logos/LOGO/Logo-Calan-blanc.png" alt="" aria-hidden="true"
                    class="h-20 sm:h-24 drop-shadow-lg">
            </a>
        </div>

        <!-- Titre de l'administration -->
        <div class="mb-6 text-center">
            <h1 class="text-white text-2xl sm:text-3xl font-bold uppercase tracking-wide drop-shadow-md">
                Administration
            </h1>
            <p class="text-white/80 text-sm mt-2">
                Espace réservé à l'équipe Calan'Couleurs
            </p>
        </div>

        <!-- Contenu du formulaire -->
        <div
            class="w-full sm:max-w-md px-6 py-8 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden rounded-xl border border-white/20">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-white/60 text-xs">
                © {{ date('Y') }} Calan'Couleurs - Tous droits réservés
            </p>
        </div>
    </div>
</body>

</html>
