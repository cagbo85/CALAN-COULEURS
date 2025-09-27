@extends('layouts.boutique')

@section('title', 'Redirection paiement - Calan\'Couleurs')

@section('content')
    <div class="max-w-2xl mx-auto text-center">
        <h1 class="text-3xl font-bold mb-6">Redirection vers HelloAsso</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <p class="mb-4">Vous allez être redirigé vers HelloAsso pour finaliser votre paiement.</p>

            <div class="bg-gray-50 rounded p-4 mb-4">
                <p><strong>Client :</strong> {{ $customer['firstname'] }} {{ $customer['lastname'] }}</p>
                <p><strong>Email :</strong> {{ $customer['email'] }}</p>
                <p><strong>Total :</strong> {{ number_format($total, 2) }}€</p>
            </div>

            <!-- Ici on intégrera HelloAsso -->
            <div class="space-y-4">
                <p class="text-sm text-gray-600">
                    (En attente de l'intégration HelloAsso)
                </p>

                <!-- Liens temporaires pour tester -->
                <div class="space-x-4">
                    <a href="{{ route('boutique.order-success') }}?payment_id=TEST_SUCCESS"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Simuler succès
                    </a>
                    <a href="{{ route('boutique.order-cancel') }}"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Simuler annulation
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
