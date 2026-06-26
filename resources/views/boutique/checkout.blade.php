@extends('layouts.boutique')

@section('title', 'Commande - Calan\'Couleurs')

@section('content')
    <div class="w-full min-h-screen bg-[#EEF1FF]">
        <section class="w-full py-10 sm:py-12"
            style="background: linear-gradient(135deg, rgba(29,63,137,0.92) 0%, rgba(119,203,243,0.72) 100%);">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white sm:text-4xl">Finaliser votre commande</h1>
                <p class="mt-2 text-white/90">Dernière étape avant le paiement sécurisé.</p>
            </div>
        </section>

        <section class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <div class="p-5 bg-white border shadow-sm rounded-2xl border-[#1d3f89]/10 sm:p-6">
                        <h2 class="text-xl font-bold text-[#1d3f89] mb-6">Informations de livraison</h2>

                        <form id="checkout-form" method="POST" action="{{ route('boutique.process-checkout') }}"
                            class="space-y-4" novalidate>
                            @csrf

                            <div>
                                <x-input-label for="email" class="block mb-1 text-sm font-semibold text-gray-700">Email
                                    <span class="text-red-500">*</span></x-input-label>
                                <x-text-input id="email" type="email" name="email" value="{{ old('email') }}"
                                    required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1d3f89]" />
                                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="firstname"
                                        class="block mb-1 text-sm font-semibold text-gray-700">Prénom <span
                                            class="text-red-500">*</span></x-input-label>
                                    <x-text-input id="firstname" type="text" name="firstname"
                                        value="{{ old('firstname') }}" required
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1d3f89]" />
                                    <x-input-error :messages="$errors->get('firstname')" class="mt-1 text-sm text-red-500" />
                                </div>

                                <div>
                                    <x-input-label for="lastname" class="block mb-1 text-sm font-semibold text-gray-700">Nom
                                        <span class="text-red-500">*</span></x-input-label>
                                    <x-text-input id="lastname" type="text" name="lastname"
                                        value="{{ old('lastname') }}" required
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1d3f89]" />
                                    <x-input-error :messages="$errors->get('lastname')" class="mt-1 text-sm text-red-500" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="adresse" class="block mb-1 text-sm font-semibold text-gray-700">Adresse
                                    <span class="text-red-500">*</span></x-input-label>
                                <x-text-input id="adresse" type="text" name="adresse" value="{{ old('adresse') }}"
                                    required placeholder="Numéro et nom de rue"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1d3f89]" />
                                <x-input-error :messages="$errors->get('adresse')" class="mt-1 text-sm text-red-500" />
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="code_postal"
                                        class="block mb-1 text-sm font-semibold text-gray-700">Code postal <span
                                            class="text-red-500">*</span></x-input-label>
                                    <x-text-input id="code_postal" type="text" name="code_postal"
                                        value="{{ old('code_postal') }}" required
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1d3f89]" />
                                    <x-input-error :messages="$errors->get('code_postal')" class="mt-1 text-sm text-red-500" />
                                </div>

                                <div>
                                    <x-input-label for="ville"
                                        class="block mb-1 text-sm font-semibold text-gray-700">Ville <span
                                            class="text-red-500">*</span></x-input-label>
                                    <x-text-input id="ville" type="text" name="ville" value="{{ old('ville') }}"
                                        required
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1d3f89]" />
                                    <x-input-error :messages="$errors->get('ville')" class="mt-1 text-sm text-red-500" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="pays" class="block mb-1 text-sm font-semibold text-gray-700">Pays
                                    <span class="text-red-500">*</span></x-input-label>
                                <select name="pays" id="pays" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1d3f89]">
                                    <option value="">Sélectionner un pays</option>
                                    <option value="FRA" {{ old('pays') == 'FRA' ? 'selected' : '' }}>France</option>
                                </select>
                                <x-input-error :messages="$errors->get('pays')" class="mt-1 text-sm text-red-500" />
                            </div>

                            <button id="checkout-submit-btn" type="submit"
                                class="inline-flex items-center justify-center w-full gap-2 px-6 py-3 font-bold text-white transition-all duration-300 shadow-lg rounded-xl hover:shadow-xl disabled:opacity-70 disabled:cursor-not-allowed"
                                style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                                <i class="fa-solid fa-credit-card"></i>
                                <span id="checkout-submit-label">Procéder au paiement</span>
                            </button>
                        </form>
                    </div>
                </div>

                <aside class="lg:col-span-5">
                    <div class="p-5 bg-white border shadow-sm rounded-2xl border-[#1d3f89]/10 sm:p-6 lg:sticky lg:top-24">
                        <h2 class="text-xl font-bold text-[#1d3f89] mb-5">Récapitulatif</h2>

                        <div class="space-y-3">
                            @foreach ($cart as $item)
                                <div class="flex gap-3 p-3 border border-gray-100 rounded-xl bg-[#f8f9fc]">
                                    @if ($item['image'])
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                                            class="flex-shrink-0 object-cover rounded-lg w-14 h-14">
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-[#1d3f89] truncate">{{ $item['title'] }}</p>

                                        @if ($item['size'] || $item['color'])
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                @if ($item['size'])
                                                    {{ $item['size'] }}
                                                @endif
                                                @if ($item['color'])
                                                    - {{ ucfirst($item['color']) }}
                                                @endif
                                            </p>
                                        @endif

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $item['quantity'] }} × {{ number_format($item['unit_price'], 2) }}€
                                        </p>
                                    </div>

                                    <div class="text-sm font-bold text-[#8F1E98]">
                                        {{ number_format($item['quantity'] * $item['unit_price'], 2) }}€
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 mt-5 space-y-2 border-t border-gray-200">
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Sous-total</span>
                                <span>{{ number_format($total, 2) }}€</span>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Livraison</span>
                                <span>Incluse</span>
                            </div>
                            <div class="flex items-center justify-between pt-2 mt-2 border-t border-gray-100">
                                <span class="font-semibold text-[#1d3f89]">Total</span>
                                <span
                                    class="text-2xl font-extrabold text-[#1d3f89]">{{ number_format($total, 2) }}€</span>
                            </div>
                        </div>

                        <a href="{{ route('boutique.cart') }}"
                            class="inline-flex items-center gap-2 mt-4 text-sm text-[#1d3f89] hover:underline">
                            Retour au panier
                        </a>
                    </div>
                </aside>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkout-form');
            const submitBtn = document.getElementById('checkout-submit-btn');
            const submitLabel = document.getElementById('checkout-submit-label');

            if (!form || !submitBtn || !submitLabel) return;

            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitLabel.textContent = 'Redirection vers le paiement...';
            });
        });
    </script>
@endsection
