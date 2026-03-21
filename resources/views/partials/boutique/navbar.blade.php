<header class="bg-white shadow-md relative z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('boutique.index') }}">
                    <img src="{{ asset('img/logos/LOGO/Logo-Calan.png') }}" alt="Calan'Couleurs" class="h-12">
                </a>
            </div>

            <!-- Navigation boutique -->
            <nav class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('boutique.index') }}"
                    class="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition rounded">
                    La Calan'Boutique
                </a>
                {{-- <a href="{{ route('boutique.products') }}?category=pulls"
                            class="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition rounded">
                            Pulls
                        </a> --}}
                <a href="{{ route('boutique.products') }}?badge=pull"
                    class="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition rounded">
                    Pulls
                </a>
                <a href="{{ route('boutique.products') }}?badge=t-shirt"
                    class="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition rounded">
                    T-shirts
                </a>
                <a href="{{ route('boutique.products') }}?badge=accessoire"
                    class="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition rounded">
                    Accessoires
                </a>
            </nav>

            <!-- Panier -->
            @php
                $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
            @endphp
            <a id="open-cart-panel"
                style="background: linear-gradient(180deg, rgba(255,15,99,0.9) 0%, rgba(143,30,152,0.9) 35%, rgba(39,42,199,0.9) 100%);"
                class="hidden lg:inline-flex items-center space-x-2 text-white font-semibold px-6 py-2.5 rounded-lg hover:from-[#FF0F63] hover:to-[#8F1E98] transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"
                    class="flex-shrink-0">
                    <path
                        d="M24 3l-.743 2h-1.929l-3.474 12h-13.239l-4.615-11h16.812l-.564 2h-13.24l2.937 7h10.428l3.432-12h4.195zm-15.5 15c-.828 0-1.5.672-1.5 1.5 0 .829.672 1.5 1.5 1.5s1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm6.9-7-1.9 7c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5z" />
                </svg>
                <span>Panier</span>
                @if ($cartCount > 0)
                    <span class="bg-pink-500 text-white rounded-full px-2 py-1 text-xs ml-1">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>
</header>
