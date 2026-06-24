@extends('layouts.app')

@section('title', 'Merci pour votre réservation ! - Calan\'Couleurs')

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">

        <div class="mx-auto mb-12 max-w-7xl">
            <div class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-[#1d3f89] mb-4">
                    Commande validée ! 🎉
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    Un grand merci pour votre soutien et votre réservation.
                </p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto mb-12">
            <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                    <h3 class="flex items-center gap-2 text-xl font-semibold text-white">
                        🎪 Prochaines étapes ?
                    </h3>
                </div>
                <div class="p-6 space-y-3 text-gray-700">
                    <ul class="mb-2 space-y-2">
                        <li class="flex items-start gap-2">
                            <span class="text-[#1d3f89] font-bold">1.</span>
                            <p>Vérifiez votre boîte mail. Un e-mail de confirmation contenant vos <strong>billets
                                    d'entrée</strong> et votre reçu vous a été envoyé par HelloAsso.</p>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#1d3f89] font-bold">2.</span>
                            <p>Téléchargez ou imprimez vos billets. Ils possèdent un <strong>QR Code</strong> qui sera
                                scanné à
                                l'entrée du festival.</p>
                        </li>
                    </ul>
                    <p class="mt-4">
                        Toute l'équipe de <span class="text-[#1d3f89] font-bold">Calan'Couleurs</span> à hâte de vous
                        retrouver pour
                        fêter cette nouvelle édition avec vous !
                    </p>

                    <div class="mt-4 text-center">
                        <a href="{{ url('/') }}"
                            class="inline-block text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
