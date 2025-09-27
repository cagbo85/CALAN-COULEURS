@extends('layouts.boutique')

@section('title', 'Boutique - Calan\'Couleurs')

@section('content')
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Boutique Calan'Couleurs</h1>
        <p class="text-xl text-gray-600">Découvrez nos produits officiels du festival</p>
    </div>

    <!-- Filtres par catégorie -->
    <div class="flex justify-center mb-8">
        <div class="flex space-x-4 bg-white rounded-lg p-2 shadow-md">
            <a href="{{ route('boutique.index') }}"
                class="px-4 py-2 rounded-md {{ !request('category') ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Tous
            </a>
            <a href="{{ route('boutique.index') }}?category=vetements"
                class="px-4 py-2 rounded-md {{ request('category') == 'vetements' ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Vêtements
            </a>
            <a href="{{ route('boutique.index') }}?category=accessoires"
                class="px-4 py-2 rounded-md {{ request('category') == 'accessoires' ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Accessoires
            </a>
            <a href="{{ route('boutique.index') }}?category=goodies"
                class="px-4 py-2 rounded-md {{ request('category') == 'goodies' ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Goodies
            </a>
        </div>
    </div>

    <!-- Grille de produits -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Aucune image</span>
                    </div>
                @endif

                <div class="p-6">
                    <h3 class="font-semibold text-lg mb-2">{{ $product->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 80) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-purple-600">{{ $product->price }}€</span>
                        <a href="{{ route('boutique.show', $product->slug) }}"
                            class="text-white font-bold py-2 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition"
                            style="background: linear-gradient(90deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%); color: white; font-weight: bold; padding: 8px 24px; border-radius: 8px; transition: all 0.3s ease;">
                            Voir
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Aucun produit disponible pour le moment.</p>
            </div>
        @endforelse
    </div>
@endsection
