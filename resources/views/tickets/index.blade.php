@extends('layouts.app')

@section('title', 'Billetterie Officielle - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">

        <div class="mx-auto mb-12 max-w-7xl">
            <div class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-[#1d3f89] mb-4">
                    Billetterie Officielle
                </h1>
                <p class="max-w-3xl mx-auto text-lg text-gray-600">
                    Réservez vos places directement et en toute sécurité pour nos prochains événements.
                </p>
            </div>
        </div>

        <div class="p-6 bg-white shadow-lg rounded-2xl shadow-xl/30 sm:p-8 lg:p-10">
            @php
                $sessionToken = session()->getId();
            @endphp
            <iframe id="haWidget" class="w-full border-none" style="min-height: 650px;" allowtransparency="true"
                scrolling="auto"
                src="https://www.helloasso-sandbox.com/associations/charlzouu-asso/evenements/test-form/widget"
                onload="window.addEventListener('message', function(e) {
                        if (e.data && e.data.height) {
                            document.getElementById('haWidget').style.height = e.data.height + 'px';
                        }
                    });
                    let checkPaymentInterval = setInterval(function() {
                            fetch('{{ route('tickets.check-status') }}')
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        clearInterval(checkPaymentInterval);
                                        window.location.href = '{{ route('tickets.thanks') }}';
                                    }
                                })
                                .catch(err => console.error('Erreur Polling:', err));
                        }, 2000);
                    ">
            </iframe>
        </div>
        <div class="mt-5 text-center">
            <p class="text-sm text-gray-400">
                🔒 Paiement sécurisé géré par HelloAsso. Vos billets et reçus vous seront envoyés directement par
                e-mail.
            </p>
        </div>
    </div>
@endsection
