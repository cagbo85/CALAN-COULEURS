<style>
    .remove-cart-btn:hover .fa-trash-can {
        animation: fa-shake 0.6s ease-in-out infinite;
    }
</style>

@if (empty($cart))
    <div class="flex flex-col items-center justify-center h-full gap-4 py-16 text-center">
        <div class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full">
            <i class="text-2xl text-gray-300 fa-solid fa-cart-shopping"></i>
        </div>
        <p class="font-medium text-gray-500">Votre panier est vide</p>
        <p class="text-sm text-gray-400">Ajoutez des articles pour les retrouver ici.</p>
    </div>
@else
    <ul class="space-y-3">
        @foreach ($cart as $cartKey => $item)
            <li class="flex items-start gap-4 p-3 bg-white border border-gray-100 shadow-sm rounded-xl">
                <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                    class="flex-shrink-0 object-cover w-16 h-16 rounded-lg">

                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-[#1d3f89] text-sm leading-snug truncate">{{ $item['title'] }}</p>

                    <div class="flex flex-wrap mt-1 gap-x-3">
                        @if ($item['size'])
                            <span class="text-xs text-gray-500">Taille : <strong>{{ $item['size'] }}</strong></span>
                        @endif
                        @if ($item['color'])
                            <span class="text-xs text-gray-500">Couleur : <strong
                                    class="capitalize">{{ $item['color'] }}</strong></span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs text-gray-400">Qté : {{ $item['quantity'] }}</span>
                        <span class="font-bold text-[#8F1E98] text-sm">
                            {{ number_format($item['unit_price'] * $item['quantity'], 2) }}€
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('boutique.update-cart') }}" class="flex-shrink-0">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                    <button type="submit" name="quantity" value="0"
                        class="flex items-center justify-center text-red-400 transition rounded-lg remove-cart-btn w-7 h-7 bg-red-50 hover:bg-red-100 hover:text-red-600"
                        title="Retirer du panier">
                        <i class="fa-solid fa-trash-can fa-sm"></i>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>

    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-200">
        <span class="text-sm font-medium text-gray-500">Total</span>
        <span class="text-xl font-extrabold text-[#1d3f89]">{{ number_format($total, 2) }}€</span>
    </div>
@endif
