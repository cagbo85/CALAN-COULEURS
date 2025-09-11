@extends('errors::minimal')

@section('title', 'Accès interdit - Calan\'Couleurs Festival 2025')

@section('code', '403')

@section('error_title', 'Zone VIP ! 🚫')

@section('message', 'Cette zone est réservée aux membres de l\'équipe. Ton pass ne te donne pas accès ici !')

@section('actions')
    <a href="{{ route('accueil') }}"
        class="inline-block bg-white text-[#8F1E98] font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300 shadow-lg">
        Retour à l'accueil
    </a>
    <br>
    <a href="{{ route('contact') }}"
        class="inline-block bg-transparent border-2 border-white text-white font-bold px-6 py-2 rounded-lg hover:bg-white hover:text-[#8F1E98] transition-all duration-300">
        Nous contacter
    </a>
@endsection

@section('additional_message', 'Si tu es membre de l\'équipe, assure-toi d\'être connecté avec le bon compte !')
