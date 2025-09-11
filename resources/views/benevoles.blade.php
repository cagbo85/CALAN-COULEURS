@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-12 px-4 h-full">
        <h1 class="text-3xl font-bold text-[#8F1E98] mb-6">Devenir bénévole</h1>
        <p class="mb-4 text-lg">
            Tu veux vivre le festival de l’intérieur ? Rejoins l’équipe des bénévoles Calan’Couleurs !
        </p>
        <ul class="mb-6 list-disc list-inside text-gray-700">
            <li>Entrée gratuite pour tous les bénévoles</li>
            <li>Choisis ta soirée de bénévolat (vendredi ou samedi)</li>
            <li>Le tee-shirt officiel est optionnel (13,90 €)</li>
            <li>Ambiance conviviale et souvenirs garantis !</li>
        </ul>
        <p class="mb-8">
            Les inscriptions se font via HelloAsso. Clique sur le bouton ci-dessous pour accéder au formulaire et réserver
            ta place !
        </p>
        <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/formulaire-benevole" target="_blank"
            rel="noopener noreferrer"
            class="inline-block text-white font-bold px-8 py-3 rounded-lg shadow-lg transition-all duration-300 text-lg"
            style="background: linear-gradient(180deg, rgba(255,15,99,0.9) 0%, rgba(143,30,152,0.9) 35%, rgba(39,42,199,0.9) 100%);">
            Devenir bénévole →
        </a>
    </div>
@endsection
