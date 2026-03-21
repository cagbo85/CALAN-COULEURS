@extends('errors::minimal')

@section('title', 'Paiement requis - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('code', '402')

@section('error_title', 'Paiement requis ! 💳')

@section('message', 'Cette fonctionnalité nécessite un paiement ou un abonnement. Direction la billetterie pour profiter pleinement du festival !')

@section('actions')
    <a href="{{ $currentEdition->reservation_url }}"
        target="_blank" rel="noopener noreferrer"
        class="inline-block bg-white text-[#8F1E98] font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
        Acheter un billet
    </a>
    <br>
    <a href="{{ route('accueil') }}"
        class="inline-block bg-transparent border-2 border-white text-white font-bold px-6 py-2 rounded-lg hover:bg-white hover:text-[#8F1E98] transition-all duration-300">
        Retour à l'accueil
    </a>
@endsection

@section('additional_message', '🎉 Avec ton billet, tu accèdes à tout le festival et ses surprises !')
