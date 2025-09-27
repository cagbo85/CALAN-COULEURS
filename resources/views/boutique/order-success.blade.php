@extends('layouts.boutique')

@section('title', 'Commande confirmée - Calan\'Couleurs')

@section('content')
    <div class="max-w-2xl mx-auto text-center">
        <div class="bg-green-50 rounded-lg p-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-green-800 mb-4">Commande confirmée !</h1>

            <p class="text-lg text-green-700 mb-6">
                Merci pour votre achat ! Votre commande #{{ $order->id }} a été enregistrée avec succès.
            </p>

            <div class="bg-white rounded-lg p-6 mb-6">
                <h2 class="font-semibold mb-2">Détails de la commande :</h2>
                <p><strong>Email :</strong> {{ $order->email }}</p>
                <p><strong>Total :</strong> {{ number_format($order->total_amount, 2) }}€</p>
                <p><strong>Statut :</strong> <span class="text-green-600">Payée</span></p>
            </div>

            <p class="text-sm text-gray-600 mb-6">
                Un email de confirmation vous a été envoyé à {{ $order->email }}
            </p>

            <a href="{{ route('boutique.index') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg">
                Retour à la boutique
            </a>
        </div>
    </div>
@endsection
