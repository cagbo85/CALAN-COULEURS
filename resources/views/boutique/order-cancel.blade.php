@extends('layouts.boutique')

@section('title', 'Commande annulée - Calan\'Couleurs')

@section('content')
    <div class="max-w-2xl mt-4 mx-auto text-center">
        <div class="bg-red-50 rounded-lg p-8">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-red-800 mb-4">Commande annulée</h1>

            <p class="text-lg text-red-700 mb-6">
                Votre commande a été annulée. Aucun montant n'a été débité.
            </p>

            <div class="space-x-4">
                <a href="{{ route('boutique.cart') }}"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg">
                    Retour au panier
                </a>
                <a href="{{ route('boutique.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">
                    Continuer les achats
                </a>
            </div>
        </div>
    </div>
@endsection
