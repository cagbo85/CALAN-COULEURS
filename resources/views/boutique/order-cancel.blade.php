@extends('layouts.boutique')

@section('title', 'Commande annulee - Calan\'Couleurs')

@section('content')
    <div class="w-full min-h-screen bg-[#EEF1FF]">
        <section class="w-full py-10 sm:py-12"
            style="background: linear-gradient(135deg, rgba(29,63,137,0.92) 0%, rgba(119,203,243,0.72) 100%);">
            <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white sm:text-4xl">Paiement annulé</h1>
                <p class="mt-2 text-white/90">Votre commande n'a pas été finalisée.</p>
            </div>
        </section>

        <section class="max-w-5xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <div class="rounded-2xl bg-white border border-[#1d3f89]/10 shadow-sm p-5 sm:p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 text-red-600 bg-red-100 rounded-full">
                                <i class="text-lg fa-solid fa-xmark"></i>
                            </div>

                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-red-700">Commande annulée</h2>
                                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                                    Le paiement a été interrompu ou annulé. Aucun montant n'a été débité.
                                    Vous pouvez revenir au panier pour corriger vos informations ou relancer votre commande.
                                </p>
                            </div>
                        </div>

                        <div class="pt-6 mt-6 border-t border-gray-100">
                            <h3 class="text-sm font-semibold text-[#1d3f89] uppercase tracking-wide">Que faire maintenant ?
                            </h3>
                            <ul class="mt-3 space-y-2 text-sm text-gray-600">
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-cart-shopping mt-0.5 text-[#1d3f89]"></i>
                                    <span>Retourner au panier pour vérifier les articles et quantités.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-credit-card mt-0.5 text-[#1d3f89]"></i>
                                    <span>Relancer le paiement quand vous êtes prêt.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-circle-info mt-0.5 text-[#1d3f89]"></i>
                                    <span>Si le problème persiste, contactez-nous via la page Contact.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="rounded-2xl bg-white border border-[#1d3f89]/10 shadow-sm p-5 sm:p-6 lg:sticky lg:top-24">
                        <h3 class="text-lg font-bold text-[#1d3f89]">Actions rapides</h3>

                        <div class="mt-5 space-y-2">
                            <a href="{{ route('boutique.cart') }}"
                                class="inline-flex items-center justify-center w-full gap-2 py-3 font-bold text-white transition shadow-lg rounded-xl hover:shadow-xl"
                                style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                                <i class="fa-solid fa-rotate-left"></i>
                                Retour au panier
                            </a>

                            <a href="{{ route('boutique.products') }}"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-white border border-[#1d3f89]/20 text-[#1d3f89] font-semibold py-3 hover:bg-[#f8f9fc] transition">
                                <i class="fa-solid fa-bag-shopping"></i>
                                Continuer les achats
                            </a>

                            <a href="{{ route('boutique.contact') }}"
                                class="inline-flex items-center justify-center w-full gap-2 py-3 font-semibold text-gray-700 transition bg-gray-100 rounded-xl hover:bg-gray-200">
                                <i class="fa-solid fa-envelope"></i>
                                Nous contacter
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </div>
@endsection
