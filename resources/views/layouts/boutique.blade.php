{{-- filepath: c:\Users\cagbo\Documents\GitHub\calan-app\resources\views\layouts\boutique.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Boutique - Calan\'Couleurs')</title>

    {{-- Meta tags dynamiques --}}
    @yield('meta')

    {{-- Scripts et styles communs --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/logos/TOUCAN.png') }}">

    <style>
        /* Couleurs Calan'Couleurs */
        :root {
            --calan-purple: #8F1E98;
            --calan-pink: #FF0F63;
            --calan-blue: #272AC7;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header Boutique -->
    <header class="bg-white shadow-lg border-b-4" style="border-color: var(--calan-purple);">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('boutique.index') }}">
                        <img src="{{ asset('img/logos/LOGO/Logo-Calan.png') }}" alt="Calan'Couleurs" class="h-16">
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold" style="color: var(--calan-purple);">
                            Calan'Boutique
                        </h1>
                        <p class="text-gray-600 text-sm">Boutique officielle du festival</p>
                    </div>
                </div>

                <!-- Navigation boutique -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('boutique.index') }}" class="text-gray-700 hover:text-purple-600 font-medium">
                        Tous les produits
                    </a>
                    <a href="{{ route('boutique.index') }}?category=vetements"
                        class="text-gray-700 hover:text-purple-600 font-medium">
                        Vêtements
                    </a>
                    <a href="{{ route('boutique.index') }}?category=accessoires"
                        class="text-gray-700 hover:text-purple-600 font-medium">
                        Accessoires
                    </a>
                    <a href="{{ route('boutique.index') }}?category=goodies"
                        class="text-gray-700 hover:text-purple-600 font-medium">
                        Goodies
                    </a>
                </nav>

                <!-- Panier -->
                <div class="flex items-center space-x-4">
                    @php
                        $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
                    @endphp
                    <a href="{{ route('boutique.cart') }}"
                        class="flex items-center space-x-2 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01">
                            </path>
                        </svg>
                        <span>Panier</span>
                        @if ($cartCount > 0)
                            <span
                                class="bg-pink-500 text-white rounded-full px-2 py-1 text-xs">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- Lien retour site principal -->
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                        ← Retour au site
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer boutique -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Calan'Couleurs - Boutique officielle</p>
            <div class="mt-4 space-x-4">
                <a href="{{ url('/contact') }}" class="text-gray-300 hover:text-white">Contact</a>
                <a href="{{ url('/charte') }}" class="text-gray-300 hover:text-white">CGV</a>
                <a href="{{ url('/') }}" class="text-gray-300 hover:text-white">Site principal</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
