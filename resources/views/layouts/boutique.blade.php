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
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @notifyCss
    <style>
        .notify {
            z-index: 999999 !important;
        }

        .connect {
            z-index: 999999 !important;
        }

        .emotify {
            z-index: 999999 !important;
        }

        .smiley {
            z-index: 999999 !important;
        }

        .toast {
            z-index: 999999 !important;
        }

        .relative [x-show="profileOpen"] {
            z-index: 50 !important;
        }
    </style>

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
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-boutique-loader.jsx'])

    {{-- Scripts additionnels par page --}}
    @stack('scripts')

    @stack('styles')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Titre dynamique --}}
    <title>@yield('title', 'Boutique - Calan\'Couleurs')</title>
</head>

<body class="flex flex-col w-full min-h-screen">
    <a href="#contenu-principal"
        class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 bg-white text-[#8F1E98] px-3 py-2 rounded">
        Aller au contenu
    </a>
    {{-- Navbar boutique --}}
    <header class="sticky top-0 z-10 bg-white">
        @include('partials.boutique.navbar')
    </header>

    {{-- Contenu principal --}}
    <main id="contenu-principal" class="flex-1 w-full" tabindex="-1">
        @yield('content')
    </main>

    {{-- Footer boutique --}}
    @include('partials.boutique.footer')

    {{-- Panneau latéral Drawers du panier --}}
    <div id="cart-panel"
        class="fixed top-0 right-0 z-50 flex flex-col h-full w-full sm:w-[420px] transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-2xl"
        style="display: none;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100"
            style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
            <div class="flex items-center gap-3">
                <i class="text-lg text-white fa-solid fa-cart-shopping"></i>
                <h2 class="text-lg font-bold tracking-wide text-white">Mon panier</h2>
            </div>
            <button id="close-cart-panel"
                class="flex items-center justify-center w-8 h-8 text-white transition rounded-full bg-white/20 hover:bg-white/40"
                aria-label="Fermer le panier">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Contenu scrollable --}}
        <div id="cart-panel-content" class="flex-1 px-5 py-4 overflow-y-auto bg-[#f8f9fc]">
            <div class="flex flex-col items-center justify-center h-full gap-6 text-gray-400">
                <i class="fa-solid fa-spinner fa-spin-pulse fa-2xl"></i>
                <span class="text-sm">Chargement...</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-5 py-4 space-y-2 bg-white border-t border-gray-100">
            <a href="{{ route('boutique.cart') }}"
                class="w-full justify-center relative inline-flex items-center gap-2 text-white font-semibold px-6 py-2.5 rounded-lg transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                <i class="fa-solid fa-bag-shopping"></i>
                Voir le panier & commander
            </a>

            <button id="close-cart-panel-footer"
                class="w-full py-1 text-sm text-center text-gray-400 transition hover:text-gray-600">
                Continuer mes achats
            </button>
        </div>
    </div>

    {{-- Overlay du panneau du panier --}}
    <div id="cart-panel-overlay" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" style="display: none;"></div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const closeBtn = document.getElementById('close-cart-panel');
            const closeBtnFooter = document.getElementById('close-cart-panel-footer');
            const cartPanel = document.getElementById('cart-panel');
            const cartOverlay = document.getElementById('cart-panel-overlay');
            const cartContent = document.getElementById('cart-panel-content');

            function openPanel() {
                if (!cartPanel || !cartOverlay) return;
                cartPanel.style.display = 'flex';
                cartOverlay.style.display = 'block';
                setTimeout(() => {
                    cartPanel.classList.remove('translate-x-full');
                }, 10);
                loadCartPanelContent();
            }

            function closePanel() {
                if (!cartPanel || !cartOverlay) return;
                cartPanel.classList.add('translate-x-full');
                setTimeout(() => {
                    cartPanel.style.display = 'none';
                    cartOverlay.style.display = 'none';
                }, 300);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closePanel);
            }

            if (closeBtnFooter) {
                closeBtnFooter.addEventListener('click', closePanel);
            }

            if (cartOverlay) {
                cartOverlay.addEventListener('click', closePanel);
            }

            // Gestion robuste des boutons ajoutés dynamiquement (React)
            document.addEventListener('click', function(e) {
                const openTrigger = e.target.closest('#open-cart-panel, #open-cart-panel-mobile');
                if (!openTrigger) return;
                e.preventDefault();
                openPanel();
            });

            window.openCartPanel = openPanel;

            window.loadCartPanelContent = function() {
                fetch('{{ route('boutique.cart') }}?ajax=1')
                    .then(response => response.text())
                    .then(html => {
                        if (cartContent) cartContent.innerHTML = html;
                    })
                    .catch(() => {
                        if (cartContent) {
                            cartContent.innerHTML =
                                '<div class="text-center text-red-500">Erreur de chargement du panier.</div>';
                        }
                    });
            };
        });
    </script>
    @notifyJs
</body>

</html>
