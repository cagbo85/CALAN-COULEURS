@extends('errors::minimal')

@section('title', 'Session expirée - Calan\'Couleurs Festival 2025')

@section('code', '419')

@section('error_title', 'Session expirée ! ⏰')

@section('message', 'Ta session a expiré pour des raisons de sécurité. Pas de panique, il suffit de recharger la page !')

@section('actions')
    <button onclick="window.location.reload()"
        class="inline-block bg-white text-[#8F1E98] font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
        Recharger la page
    </button>
    <br>
    <a href="{{ route('accueil') }}"
        class="inline-block bg-transparent border-2 border-white text-white font-bold px-6 py-2 rounded-lg hover:bg-white hover:text-[#8F1E98] transition-all duration-300">
        Retour à l'accueil
    </a>
@endsection

@section('additional_message', 'Les sessions expirent automatiquement pour protéger tes données !')
