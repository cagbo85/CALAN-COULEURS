@extends('layouts.app')

@section('title', 'Merci pour votre réservation ! - Calan\'Couleurs')

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">

        <div class="w-full max-w-2xl p-8 text-center bg-white shadow-2xl rounded-3xl shadow-xl/20 animate-fade-in">

            <div class="inline-flex items-center justify-center w-20 h-20 mb-6 bg-green-100 rounded-full">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1d3f89] mb-3">
                Commande validée ! 🎉
            </h1>
            <p class="mb-8 text-xl font-medium text-gray-700">
                Un grand merci pour votre soutien et votre réservation.
            </p>

            <div class="p-6 mb-8 text-left border border-blue-100 bg-blue-50/50 rounded-2xl">
                <h3 class="text-sm font-bold text-[#1d3f89] uppercase tracking-wider mb-3">
                    Prochaines étapes :
                </h3>
                <ul class="space-y-3 text-sm text-gray-600 sm:text-base">
                    <li class="flex items-start">
                        <span
                            class="flex items-center justify-center w-5 h-5 mr-3 text-xs font-bold text-white bg-[#1d3f89] rounded-full shrink-0 mt-0.5">1</span>
                        <span>Vérifiez votre boîte mail. Un e-mail de confirmation contenant vos <strong>billets
                                d'entrée</strong> et votre reçu vous a été envoyé par <strong>HelloAsso</strong>.</span>
                    </li>
                    <li class="flex items-start">
                        <span
                            class="flex items-center justify-center w-5 h-5 mr-3 text-xs font-bold text-white bg-[#1d3f89] rounded-full shrink-0 mt-0.5">2</span>
                        <span>Téléchargez ou imprimez vos billets. Ils possèdent un QR Code qui sera scanné à l'entrée du
                            festival.</span>
                    </li>
                </ul>
            </div>

            <p class="mb-8 text-sm text-gray-500 sm:text-base">
                Toute l'équipe de Calan'Couleurs a hâte de vous retrouver pour fêter cette nouvelle édition avec vous ! 🎨✨
            </p>

            <div class="flex flex-col items-center justify-center gap-4 pt-6 border-t border-gray-100 sm:flex-row">
                <a href="{{ url('/') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-[#1d3f89] hover:bg-[#15306b] transition-colors duration-200 shadow-md">
                    Retour à l'accueil
                </a>

                {{-- Si ta route boutique s'appelle autrement, ajuste le nom ici --}}
                @if (Route::has('products.index'))
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center w-full px-6 py-3 text-base font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 sm:w-auto rounded-xl hover:bg-gray-50">
                        Visiter la boutique
                    </a>
                @endif
            </div>

        </div>
    </div>
@endsection
