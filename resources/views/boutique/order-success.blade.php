@extends('layouts.boutique')

@section('title', 'Commande confirmée - Calan\'Couleurs')

@section('content')
    @php
        $isPaid = ($order->status ?? null) === 'paid';
        $displayStatus = $order->payment_status ?? ($isPaid ? 'traitée' : 'en attente');
    @endphp

    <div class="w-full min-h-screen bg-[#EEF1FF]">
        <section class="w-full py-10 sm:py-12"
            style="background: linear-gradient(135deg, rgba(29,63,137,0.92) 0%, rgba(119,203,243,0.72) 100%);">
            <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white sm:text-4xl">
                    @if ($isPaid)
                        Commande confirmée
                    @else
                        Commande en cours de validation
                    @endif
                </h1>
                <p class="mt-2 text-white/90">
                    Numero de commande: #{{ $order->id }}
                </p>
            </div>
        </section>

        <section class="max-w-5xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <div class="rounded-2xl bg-white border border-[#1d3f89]/10 shadow-sm p-5 sm:p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0
                                {{ $isPaid ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                @if ($isPaid)
                                    <i class="text-lg fa-solid fa-check"></i>
                                @else
                                    <i class="text-lg fa-solid fa-clock"></i>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h2 class="text-xl font-bold {{ $isPaid ? 'text-green-700' : 'text-orange-700' }}">
                                    @if ($isPaid)
                                        Paiement reçu avec succès
                                    @else
                                        Paiement en attente de confirmation
                                    @endif
                                </h2>

                                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                                    @if ($isPaid)
                                        Merci pour votre achat. Votre commande a été enregistrée et sera préparée rapidement.
                                    @else
                                        Votre commande est bien créée. La confirmation définitive dépend de la validation du paiement.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 pt-6 mt-6 text-sm border-t border-gray-100 sm:grid-cols-2">
                            <div class="rounded-xl bg-[#f8f9fc] border border-gray-100 p-4">
                                <p class="text-gray-500">Email</p>
                                <p class="font-semibold text-[#1d3f89] mt-1">{{ $order->email }}</p>
                            </div>

                            <div class="rounded-xl bg-[#f8f9fc] border border-gray-100 p-4">
                                <p class="text-gray-500">Total</p>
                                <p class="font-semibold text-[#1d3f89] mt-1">{{ number_format($order->total_amount, 2) }}€</p>
                            </div>

                            <div class="rounded-xl bg-[#f8f9fc] border border-gray-100 p-4">
                                <p class="text-gray-500">Statut commande</p>
                                <p class="font-semibold mt-1 {{ $isPaid ? 'text-green-700' : 'text-orange-700' }}">
                                    {{ $isPaid ? 'Payée' : 'En attente' }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-[#f8f9fc] border border-gray-100 p-4">
                                <p class="text-gray-500">Statut paiement</p>
                                <p class="font-semibold text-[#1d3f89] mt-1 uppercase">{{ $displayStatus }}</p>
                            </div>
                        </div>

                        @if (!empty($order->helloasso_id))
                            <p class="mt-4 text-xs text-gray-500">
                                Reference HelloAsso: {{ $order->helloasso_id }}
                            </p>
                        @endif
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="rounded-2xl bg-white border border-[#1d3f89]/10 shadow-sm p-5 sm:p-6 lg:sticky lg:top-24">
                        <h3 class="text-lg font-bold text-[#1d3f89]">Prochaines étapes</h3>

                        <ul class="mt-4 space-y-3 text-sm text-gray-600">
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-envelope mt-0.5 text-[#1d3f89]"></i>
                                <span>Un email de recapitulatif de paiement de la part de HelloAsso vous sera envoyé.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-box mt-0.5 text-[#1d3f89]"></i>
                                <span>Vous recevrez les informations de notre part concernant le récapatitulatif de vos articles ainsi que le suivi de votre commande.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-info mt-0.5 text-[#1d3f89]"></i>
                                <span>Pensez à vérifier les courriers indésirables.</span>
                            </li>
                        </ul>

                        <div class="mt-6 space-y-2">
                            <a href="{{ route('boutique.index') }}"
                                class="inline-flex items-center justify-center w-full gap-2 py-3 font-bold text-white transition shadow-lg rounded-xl hover:shadow-xl"
                                style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                                <i class="fa-solid fa-store"></i>
                                Retour à la boutique
                            </a>

                            <a href="{{ route('boutique.products') }}"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-white border border-[#1d3f89]/20 text-[#1d3f89] font-semibold py-3 hover:bg-[#f8f9fc] transition">
                                <i class="fa-solid fa-shirt"></i>
                                Continuer les achats
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </div>
@endsection
