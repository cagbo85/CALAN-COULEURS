@extends('layouts.boutique')

@section('title', 'Commande - Calan\'Couleurs')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">Finaliser votre commande</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulaire client -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Informations de livraison</h2>

                <form method="POST" action="{{ route('boutique.process-checkout') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email *
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prénom et Nom -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">
                                Prénom *
                            </label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @error('firstname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">
                                Nom *
                            </label>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @error('lastname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse *
                        </label>
                        <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" required
                            placeholder="Numéro et nom de rue"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('adresse')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ville et Code postal -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="code_postal" class="block text-sm font-medium text-gray-700 mb-1">
                                Code postal *
                            </label>
                            <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal') }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @error('code_postal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">
                                Ville *
                            </label>
                            <input type="text" id="ville" name="ville" value="{{ old('ville') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @error('ville')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pays -->
                    <div>
                        <label for="pays" class="block text-sm font-medium text-gray-700 mb-1">
                            Pays *
                        </label>
                        <select id="pays" name="pays" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Sélectionner un pays</option>
                            <option value="France" {{ old('pays') == 'France' ? 'selected' : '' }}>France</option>
                            <option value="Belgique" {{ old('pays') == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                            <option value="Suisse" {{ old('pays') == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                            <option value="Canada" {{ old('pays') == 'Canada' ? 'selected' : '' }}>Canada</option>
                        </select>
                        @error('pays')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton de validation -->
                    <button type="submit"
                        class="w-full text-white font-bold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition"
                        style="background: linear-gradient(135deg, rgba(39,42,199,0.9) 0%, rgba(143,30,152,0.9) 50%, rgba(255,15,99,0.9) 100%);">
                        Procéder au paiement
                    </button>
                </form>
            </div>

            <!-- Récapitulatif commande -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Récapitulatif de votre commande</h2>

                <div class="space-y-4 mb-6">
                    @foreach ($cart as $item)
                        <div class="flex items-center space-x-4 py-3 border-b border-gray-100">
                            @if ($item['image'])
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                                    class="w-16 h-16 object-cover rounded">
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold">{{ $item['title'] }}</h4>
                                @if ($item['size'] || $item['color'])
                                    <p class="text-sm text-gray-600">
                                        @if ($item['size'])
                                            {{ $item['size'] }}
                                        @endif
                                        @if ($item['color'])
                                            - {{ ucfirst($item['color']) }}
                                        @endif
                                    </p>
                                @endif
                                <p class="text-sm text-gray-600">
                                    {{ $item['quantity'] }} × {{ number_format($item['unit_price'], 2) }}€
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">
                                    {{ number_format($item['quantity'] * $item['unit_price'], 2) }}€
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center text-xl font-bold">
                        <span>Total :</span>
                        <span class="text-purple-600">{{ number_format($total, 2) }}€</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Frais de port inclus</p>
                </div>
            </div>
        </div>
    </div>
@endsection
