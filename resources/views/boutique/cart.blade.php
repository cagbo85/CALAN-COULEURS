@extends('layouts.boutique')

@section('title', 'Panier - Calan\'Couleurs')

@section('content')
    <div class="w-full bg-[#EEF1FF] min-h-screen">
        <section class="w-full py-10 sm:py-12"
            style="background: linear-gradient(135deg, rgba(29,63,137,0.92) 0%, rgba(119,203,243,0.72) 100%);">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white sm:text-4xl">Mon panier</h1>
                <p class="mt-2 text-white/90">Vérifie tes articles avant de passer commande.</p>
            </div>
        </section>
        <section class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (count($cart) > 0)
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                    <div class="space-y-4 lg:col-span-8">
                        @foreach ($cart as $cartKey => $item)
                            @php
                                $options = $variantsByProduct[$item['product_id']] ?? collect();
                            @endphp

                            <article class="rounded-2xl bg-white border border-[#1d3f89]/10 shadow-sm p-4 sm:p-5">
                                <div class="flex gap-4">
                                    <div
                                        class="flex-shrink-0 w-24 h-24 overflow-hidden bg-gray-100 sm:w-28 sm:h-28 rounded-xl">
                                        @if ($item['image'])
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                                                class="object-cover w-full h-full">
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h2 class="font-bold text-[#1d3f89] text-base sm:text-lg truncate">
                                            {{ $item['title'] }}</h2>

                                        <div class="mt-1 text-sm text-gray-500">
                                            Prix unitaire : <span
                                                class="font-semibold text-gray-800">{{ number_format($item['unit_price'], 2) }}€</span>
                                        </div>

                                        <form method="POST" action="{{ route('boutique.update-cart') }}"
                                            class="grid grid-cols-1 gap-3 mt-3 sm:grid-cols-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="cart_key" value="{{ $cartKey }}">

                                            <div class="space-y-1">
                                                <label
                                                    class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Taille
                                                    / Couleur</label>
                                                <select name="variant_id"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg">
                                                    @foreach ($options as $variant)
                                                        @php
                                                            $sizeLabel = optional($variant->size)->label ?: '-';
                                                            $colorLabel = optional($variant->color)->name ?: '-';
                                                        @endphp
                                                        <option value="{{ $variant->id }}"
                                                            {{ (int) $item['variant_id'] === (int) $variant->id ? 'selected' : '' }}>
                                                            {{ $sizeLabel }} - {{ ucfirst($colorLabel) }}
                                                            @if ($variant->quantity <= 3)
                                                                (plus que {{ $variant->quantity }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="space-y-1">
                                                <label
                                                    class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Quantité</label>
                                                <div class="flex items-center gap-2">
                                                    <input type="number" name="quantity" min="0" max="10"
                                                        value="{{ $item['quantity'] }}"
                                                        class="w-16 py-2 text-sm text-center border border-gray-300 rounded-lg">
                                                    <button type="submit"
                                                        class="px-3 h-9 rounded-lg bg-[#1d3f89] text-white text-xs font-semibold hover:bg-[#16336f] transition">
                                                        Mettre à jour
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="flex items-center justify-between mt-4">
                                            <div class="text-sm text-gray-500">
                                                Variante actuelle :
                                                <span class="font-semibold text-gray-800">
                                                    {{ $item['size'] ?: '-' }} -
                                                    {{ $item['color'] ? ucfirst($item['color']) : '-' }}
                                                </span>
                                            </div>

                                            <div class="text-lg font-extrabold text-[#8F1E98]">
                                                {{ number_format($item['quantity'] * $item['unit_price'], 2) }}€
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <form method="POST" action="{{ route('boutique.update-cart') }}"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                                                <input type="hidden" name="quantity" value="0">
                                                <button type="submit" onclick="return confirm('Supprimer cet article ?')"
                                                    class="inline-flex items-center gap-2 text-sm text-red-500 transition hover:text-red-700">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                    Retirer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <aside class="lg:col-span-4">
                        <div class="rounded-2xl bg-white border border-[#1d3f89]/10 shadow-sm p-5 lg:sticky lg:top-24">
                            <h3 class="text-lg font-bold text-[#1d3f89]">Récapitulatif</h3>

                            <div class="mt-4 space-y-2 text-sm">
                                <div class="flex items-center justify-between text-gray-600">
                                    <span>Sous-total</span>
                                    <span>{{ number_format($total, 2) }}€</span>
                                </div>
                                <div class="flex items-center justify-between text-gray-600">
                                    <span>Livraison</span>
                                    <span>Calculée à l'étape suivante</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-200">
                                <span class="font-semibold text-[#1d3f89]">Total</span>
                                <span class="text-2xl font-extrabold text-[#1d3f89]">{{ number_format($total, 2) }}€</span>
                            </div>

                            <a href="{{ route('boutique.checkout') }}"
                                class="mt-5 w-full inline-flex justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-[#1d3f89] to-[#77cbf3] hover:from-[#8F1E98] hover:to-[#FF0F63] text-white font-bold py-3 transition">
                                <i class="fa-solid fa-credit-card"></i>
                                Commander
                            </a>

                            <div class="flex items-center justify-between mt-3">
                                <a href="{{ route('boutique.products') }}" class="text-sm text-[#1d3f89] hover:underline">
                                    Continuer mes achats
                                </a>

                                <form method="POST" action="{{ route('boutique.clear-cart') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Vider le panier ?')"
                                        class="text-sm text-red-500 hover:text-red-700">
                                        Vider
                                    </button>
                                </form>
                            </div>
                        </div>
                    </aside>
                </div>
            @else
                <div
                    class="text-center py-14 sm:py-16 px-6 bg-white rounded-2xl border border-[#1d3f89]/10 shadow-sm max-w-2xl mx-auto">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-[#e8f5fc] flex items-center justify-center">
                        <i class="fa-solid fa-cart-shopping text-2xl text-[#1d3f89]"></i>
                    </div>

                    <h2 class="text-2xl font-extrabold text-[#1d3f89] tracking-tight">
                        Votre panier est vide
                    </h2>

                    <p class="max-w-md mx-auto mt-3 text-sm text-gray-500 sm:text-base">
                        Découvrez nos collections et ajoutez vos articles préférés pour préparer votre commande.
                    </p>

                    <div class="flex flex-col items-center justify-center gap-3 mt-7 sm:flex-row">
                        <a href="{{ route('boutique.products') }}"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 font-bold text-white transition-all duration-300 shadow-md rounded-xl hover:shadow-lg"
                            style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                            <i class="fa-solid fa-bag-shopping"></i>
                            Voir nos produits
                        </a>

                        <a href="{{ route('boutique.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl font-semibold text-[#1d3f89] border border-[#1d3f89]/20 bg-white hover:bg-[#f8f9fc] transition">
                            <i class="fa-solid fa-house"></i>
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection
