@extends('errors::minimal')

@section('title', 'Trop de requêtes - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('code', '429')

@section('error_title', 'Ralentis un peu ! 🐌')

@section('message', 'Tu envoies trop de requêtes à la fois ! Prends une pause, le festival n\'est pas pressé.')

@section('actions')
    <button onclick="setTimeout(() => window.location.reload(), 3000)"
        class="inline-block bg-white text-[#8F1E98] font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
        Réessayer dans 3 secondes
    </button>
    <br>
    <a href="{{ route('accueil') }}"
        class="inline-block bg-transparent border-2 border-white text-white font-bold px-6 py-2 rounded-lg hover:bg-white hover:text-[#8F1E98] transition-all duration-300">
        Retour à l'accueil
    </a>
@endsection

@section('additional_message', 'Patience ! Les meilleures choses arrivent à ceux qui savent attendre 🎶')
