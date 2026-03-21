@extends('layouts.boutique')

@section('title', 'Panier - Calan\'Couleurs')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Mon Panier</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (count($cart) > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Caractéristiques</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prix unitaire</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cart as $cartKey => $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($item['image'])
                                                <img class="h-16 w-16 rounded-md object-cover mr-4"
                                                    src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}">
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $item['title'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($item['size'] || $item['color'])
                                            @if ($item['size'])
                                                {{ $item['size'] }}
                                            @endif
                                            @if ($item['color'])
                                                - {{ ucfirst($item['color']) }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($item['unit_price'], 2) }}€
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('boutique.update-cart') }}"
                                            class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                min="0" max="10"
                                                class="w-16 px-2 py-1 border border-gray-300 rounded text-sm">
                                            <button type="submit" class="ml-2 text-blue-600 hover:text-blue-900 text-sm">
                                                Modifier
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ number_format($item['quantity'] * $item['unit_price'], 2) }}€
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                        <form method="POST" action="{{ route('boutique.update-cart') }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                                            <input type="hidden" name="quantity" value="0">
                                            <button type="submit" class="hover:text-red-900"
                                                onclick="return confirm('Supprimer cet article ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total et actions -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-4">
                            <a href="{{ route('boutique.products') }}" class="text-blue-600 hover:text-blue-900">
                                ← Continuer les achats
                            </a>
                            <form method="POST" action="{{ route('boutique.clear-cart') }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Vider le panier ?')">
                                    Vider le panier
                                </button>
                            </form>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">
                                Total: {{ number_format($total, 2) }}€
                            </div>
                            <a href="{{ route('boutique.checkout') }}"
                                class="mt-4 w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-lg text-center inline-block">
                                Commander
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg mb-4">Votre panier est vide</p>
                <a href="{{ route('boutique.products') }}"
                    class="text-center bg-[#8F1E98] hover:bg-[#FF0F63] text-white font-bold rounded-lg transition py-2 px-4">
                    Voir nos produits
                </a>
            </div>
        @endif
    </div>
@endsection
