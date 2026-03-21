@if (empty($cart))
    <div class="text-center text-gray-400 py-8">Votre panier est vide.</div>
@else
    <ul class="divide-y divide-gray-200">
        @foreach ($cart as $cartKey => $item)
            <li class="flex items-center py-6">
                <img src="{{ asset($item['image']) }}" alt=""
                    class="w-35 h-35 object-cover rounded-lg mr-4 shadow">
                <div class="flex-1">
                    <div class="font-semibold text-lg">{{ $item['title'] }}</div>
                    <div class="text-xs text-gray-400 mb-1"><span class="font-mono">{{ $item['sku'] }}</span></div>
                    @if ($item['size'])
                        <div class="text-sm text-gray-600 mb-1">Taille : <span
                                class="font-semibold">{{ $item['size'] }}</span></div>
                    @endif
                    @if ($item['color'])
                        <div class="text-sm text-gray-600 mb-1">Couleur : <span
                                class="font-semibold capitalize">{{ $item['color'] }}</span></div>
                    @endif
                    <div class="text-sm text-gray-600 mt-2">Quantité : <span
                            class="font-semibold">{{ $item['quantity'] }}</span></div>
                </div>
                <div class="flex flex-col items-end space-y-2 min-w-[80px]">
                    <div class="font-bold text-[#8F1E98] text-lg">
                        {{ number_format($item['unit_price'] * $item['quantity'], 2) }}€
                    </div>
                    {{-- Boutons de mise à jour du panier pour la quantité --}}
                    {{-- <form method="POST" action="{{ route('boutique.update-cart') }}" class="flex items-center">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="cart_key" value="{{ $cartKey }}">

                        <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}"
                            class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 text-lg font-bold"
                            @if ($item['quantity'] <= 1) disabled @endif>-</button>

                        <span class="mx-2 text-base font-semibold">{{ $item['quantity'] }}</span>

                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                            class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 text-lg font-bold">+</button>

                    </form> --}}
                    <form method="POST" action="{{ route('boutique.update-cart') }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                        <button type="submit" name="quantity" value="0"
                            class="px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-semibold">
                            Retirer
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="mt-4 text-right font-bold text-xl">
        Total : {{ number_format($total, 2) }}€
    </div>
@endif
