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

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TBMDHRBX');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body class="w-full min-h-screen flex flex-col">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TBMDHRBX" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <a href="#contenu-principal"
        class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 bg-white text-[#8F1E98] px-3 py-2 rounded">
        Aller au contenu
    </a>
    {{-- Navbar commune --}}
    <header class="sticky top-0 z-10 bg-white">
        @include('partials.navbar')
    </header>

    {{-- Contenu principal --}}
    <main id="contenu-principal" class="w-full flex-1" tabindex="-1">
        @yield('content')
    </main>

    {{-- Footer commun --}}
    @include('partials.footer')

    {{-- Scripts additionnels en fin de page --}}
    @stack('scripts-footer')
</body>

</html>
