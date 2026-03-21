@extends('errors::minimal')

@section('title', 'Maintenance - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('code', '503')

@section('error_title', 'Maintenance en cours ! 🔧')

@section('message', 'Nous préparons de nouvelles surprises ! Le site sera de retour très bientôt.')

@section('actions')
    <button onclick="window.location.reload()"
        class="inline-block bg-white text-[#8F1E98] font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
        Réessayer
    </button>
    <br>
    <a href="https://www.instagram.com/calan_couleurs/" target="_blank" rel="noopener noreferrer"
        class="inline-block bg-transparent border-2 border-white text-white font-bold px-6 py-2 rounded-lg hover:bg-white hover:text-[#8F1E98] transition-all duration-300">
        Nous suivre sur Instagram
    </a>
@endsection

@section('additional_message', 'Pendant ce temps, retrouvez toute l\'actualité sur nos réseaux sociaux !')
