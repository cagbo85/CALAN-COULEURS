<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    {{-- Meta tags dynamiques --}}
    @yield('meta')

    {{-- Scripts et styles communs --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="{{ secure_asset('img/logos/TOUCAN.png') }}">

    {{-- @notifyCss --}}
    {{-- <script src="{{ secure_asset('vendor/mckenziearts/laravel-notify/js/notify.js') }}"></script> --}}
    <style>
        /* Couleurs Calan'Couleurs */
        :root {
            --calan-purple: #8F1E98;
            --calan-pink: #FF0F63;
            --calan-blue: #272AC7;
        }

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

    {{-- @viteReactRefresh --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx', 'resources/js/timer-loader.jsx', 'resources/js/stands-loader.jsx', 'resources/js/faq-loader.jsx']) --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx']) --}}

    {{-- Scripts additionnels par page --}}
    @stack('scripts')

    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

    {{-- Titre dynamique --}}
    <title>@yield('title', 'Boutique - Calan\'Couleurs')</title>
</head>

<body class="w-full min-h-screen flex flex-col">
    {{-- <x-notify::notify /> --}}
    <a href="#contenu-principal"
        class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 bg-white text-[#8F1E98] px-3 py-2 rounded">
        Aller au contenu
    </a>
    {{-- Navbar boutique --}}
    <header class="sticky top-0 z-10 bg-white items-center">
        @include('partials.boutique.navbar')
    </header>

    <!-- Contenu principal -->
    <main id="contenu-principal" class="w-full flex-1 bg-gray-50" tabindex="-1">
        @yield('content')
    </main>

    {{-- Footer boutique --}}
    @include('partials.boutique.footer')

    {{-- Panneau latéral Drawers du panier --}}
    <div id="cart-panel"
        class="fixed top-0 right-0 w-1/3 max-w-full h-full bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col"
        style="display: none;">
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-xl font-bold">Votre panier</h2>
            <button id="close-cart-panel" class="text-gray-500 hover:text-[#FF0F63] text-2xl">&times;</button>
        </div>
        <div id="cart-panel-content" class="flex-1 overflow-y-auto p-4">
            <!-- Les articles du panier seront injectés ici en JS -->
            <div class="text-center text-gray-400">Chargement...</div>
        </div>
        <div class="p-4 border-t">
            <a href="{{ route('boutique.cart') }}"
                class="w-full block text-center bg-[#8F1E98] hover:bg-[#FF0F63] text-white font-bold py-3 rounded-lg transition">
                Passer commande
            </a>
        </div>
    </div>

    {{-- Overlay du panneau du panier --}}
    <div id="cart-panel-overlay" class="fixed inset-0 bg-black bg-opacity-40 z-40" style="display: none;"></div>

    {{-- @include('notify::components.notify') --}}

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('admin-trigger');
            let clicks = 0;
            let timer = null;

            function goAdmin() {
                window.open('{{ route('login') }}', '_blank', 'noopener,noreferrer');
            }

            trigger.addEventListener('click', () => {
                clicks++;
                if (clicks === 1) {
                    timer = setTimeout(() => {
                        clicks = 0;
                    }, 500);
                } else if (clicks === 2) {
                    clearTimeout(timer);
                    clicks = 0;
                    goAdmin();
                }
            });

            trigger.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    clicks++;
                    if (clicks === 1) {
                        timer = setTimeout(() => {
                            clicks = 0;
                        }, 500);
                    } else if (clicks === 2) {
                        clearTimeout(timer);
                        clicks = 0;
                        goAdmin();
                    }
                }
            });

            // Forcer la fermeture de toutes les notifications après 3 secondes
            setTimeout(function() {
                // Cacher toutes les notifications visibles
                document.querySelectorAll('.notify, .connect, .toast').forEach(function(notification) {
                    if (notification.style.display !== 'none') {
                        notification.style.display = 'none';
                    }
                });
            }, 5000);

            // Gestion de l'affichage du panneau du panier
            const openBtn = document.getElementById('open-cart-panel');
            const closeBtn = document.getElementById('close-cart-panel');
            const cartPanel = document.getElementById('cart-panel');
            const cartOverlay = document.getElementById('cart-panel-overlay');

            if (openBtn && cartPanel && cartOverlay && closeBtn) {
                openBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    cartPanel.style.display = 'flex';
                    cartOverlay.style.display = 'block';
                    setTimeout(() => {
                        cartPanel.classList.remove('translate-x-full');
                    }, 10);
                    loadCartPanelContent();
                });

                closeBtn.addEventListener('click', closePanel);
                cartOverlay.addEventListener('click', closePanel);

                function closePanel() {
                    cartPanel.classList.add('translate-x-full');
                    setTimeout(() => {
                        cartPanel.style.display = 'none';
                        cartOverlay.style.display = 'none';
                    }, 300);
                }
            }

            window.openCartPanel = function() {
                if (cartPanel && cartOverlay) {
                    cartPanel.style.display = 'flex';
                    cartOverlay.style.display = 'block';
                    setTimeout(() => {
                        cartPanel.classList.remove('translate-x-full');
                    }, 10);
                    loadCartPanelContent();
                }
            }

            window.loadCartPanelContent = function() {
                fetch('{{ route('boutique.cart') }}?ajax=1')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('cart-panel-content').innerHTML = html;
                    })
                    .catch(() => {
                        document.getElementById('cart-panel-content').innerHTML =
                            '<div class="text-center text-red-500">Erreur de chargement du panier.</div>';
                    });
            }

            window.updateCartCounter = function(count) {
                const cartButton = document.getElementById('open-cart-panel');
                if (cartButton) {
                    let countBadge = cartButton.querySelector('.bg-pink-500');

                    if (count > 0) {
                        if (!countBadge) {
                            countBadge = document.createElement('span');
                            countBadge.className = 'bg-pink-500 text-white rounded-full px-2 py-1 text-xs ml-1';
                            cartButton.appendChild(countBadge);
                        }
                        countBadge.textContent = count;
                    } else {
                        if (countBadge) {
                            countBadge.remove();
                        }
                    }
                }
            }
        });
    </script>
    {{-- @notifyJs --}}
</body>

</html>
