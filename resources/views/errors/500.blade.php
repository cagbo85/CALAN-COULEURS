@extends('errors::minimal')

@section('title', 'Erreur serveur - Calan\'Couleurs Festival 2025')

@section('code', '500')

@section('error_title', 'Problème technique ! ⚡')

@section('message', 'On dirait que nos serveurs font un petit bug... Nos techniciens sont sur le coup !')

@section('actions')
    <button onclick="window.location.reload()"
        class="inline-block bg-white text-[#8F1E98] font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
        Réessayer
    </button>
    <br>
    <a href="{{ route('accueil') }}"
        class="inline-block bg-transparent border-2 border-white text-white font-bold px-6 py-2 rounded-lg hover:bg-white hover:text-[#8F1E98] transition-all duration-300">
        Retour à l'accueil
    </a>
@endsection

@section('additional_message', 'Notre équipe technique travaille pour remettre tout en marche rapidement !')
