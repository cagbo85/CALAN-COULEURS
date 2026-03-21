@extends('errors::minimal')

@section('title', 'Erreur 404 - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('code', '404')

@section('error_title', 'Page introuvable ! 🎵')

@section('message', 'On dirait que cette page s\'est perdue dans les coulisses du festival ! Retournons à la scène
    principale.')

@section('actions')
    <a href="{{ route('accueil') }}"
        class="inline-block bg-white text-[#FF0F63] font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
        Retour à l'accueil
    </a>
    <br>
    <a href="{{ route('contact') }}"
        class="inline-block bg-transparent border-2 border-white text-white font-bold px-6 py-2 rounded-lg hover:bg-white hover:text-[#FF0F63] transition-all duration-300">
        Nous contacter
    </a>
@endsection

@section('additional_message', 'Les meilleurs moments se vivent sur le festival, pas sur les pages d\'erreur !')
