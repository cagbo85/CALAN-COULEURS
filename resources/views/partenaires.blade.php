@extends('layouts.app')

@section('title', 'Partenaires - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('content')
    <div class="w-full min-h-full bg-[#EEF1FF] px-4 py-10 sm:px-6 lg:px-8">
        @if ($partnerCount === 0)
            <div class="mx-auto flex min-h-[calc(100dvh-220px)] max-w-7xl items-center justify-center">
                <article
                    class="w-full max-w-2xl overflow-hidden border-2 shadow-xl bg-white/95 backdrop-blur-sm rounded-xl border-white/50">
                    <div class="p-8 text-white" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%)">
                        <h2 class="text-3xl font-bold tracking-wide text-center uppercase sm:text-left">
                            🤝 Ça collabore !
                        </h2>
                    </div>

                    <div class="p-8 text-center">
                        <p class="mb-4 text-lg leading-relaxed text-gray-700">
                            Les partenaires de cette édition seront annoncés prochainement.
                        </p>
                        <p class="mb-6 text-base text-gray-600">
                            Revenez bientôt pour découvrir celles et ceux qui nous soutiennent. 🤝
                        </p>

                        <div class="flex justify-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-[#1d3f89] rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce" style="animation-delay: 0.1s">
                            </div>
                            <div class="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce" style="animation-delay: 0.2s">
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @else
            <!-- En-tête -->
            <div class="mx-auto mb-12 max-w-7xl">
                <div class="mb-8 text-center">
                    <h1 class="text-4xl sm:text-5xl font-bold text-[#1d3f89] mb-4">
                        Nos partenaires
                    </h1>
                    <p class="max-w-3xl mx-auto text-lg text-gray-600">
                        Ils nous accompagnent et nous soutiennent pour faire de Calan'Couleurs une expérience unique.
                    </p>
                </div>

                <!-- Statistiques -->
                <div class="flex flex-wrap justify-center gap-4 mb-8">
                    <div class="px-6 py-3 bg-white border border-[#1d3f89]/15 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl text-[#8F1E98]">{{ $partnerCount }}</span>
                            <span class="font-medium text-gray-600">Partenaires</span>
                        </div>
                    </div>
                </div>

                <div class="grid items-stretch gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($partenaires as $partner)
                        <article
                            class="group flex h-full flex-col overflow-hidden rounded-2xl border border-[#1d3f89]/10 bg-white shadow-[0_12px_28px_rgba(16,24,40,0.08)] transition hover:-translate-y-1 hover:shadow-[0_18px_40px_rgba(16,24,40,0.12)]">

                            <div
                                class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-[#eef4ff] to-[#fdf2f8] shrink-0">
                                @if (!empty($partner->photo))
                                    <img src="{{ $partner->photo }}" alt="{{ $partner->name }}"
                                        class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                                @elseif (!empty($partner->logo))
                                    <img src="{{ $partner->logo }}" alt="{{ $partner->name }}"
                                        class="object-contain w-full h-full p-5 transition duration-300 bg-white group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center h-full px-4 text-center">
                                        <div>
                                            <div
                                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#1d3f89] text-2xl text-white shadow-lg">
                                                {{ mb_substr($partner->name, 0, 1) }}
                                            </div>
                                            <p class="mt-3 text-sm font-semibold text-[#1d3f89]">{{ $partner->name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col flex-1 p-5">
                                <h3 class="text-lg font-bold text-gray-900">{{ $partner->name }}</h3>

                                @if (!empty($partner->description))
                                    <p class="my-2 text-sm leading-relaxed text-gray-600">
                                        {{ $partner->description }}
                                    </p>
                                @endif

                                <div class="mt-auto border-t border-gray-100">
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @if (!empty($partner->site_url))
                                            <a href="{{ $partner->site_url }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#1d3f89]/15 bg-[#f8fbff] text-[#1d3f89] transition hover:bg-[#1d3f89] hover:text-white"
                                                aria-label="Site" title="Visiter le site">
                                                <i class="block leading-none fa-solid fa-globe fa-lg fa-fw"></i>
                                            </a>
                                        @endif
                                        @if (!empty($partner->facebook_url))
                                            <a href="{{ $partner->facebook_url }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#1d3f89]/15 bg-[#f8fbff] text-[#1d3f89] transition hover:bg-[#1d3f89] hover:text-white"
                                                aria-label="Facebook" title="Facebook">
                                                <i class="block leading-none fa-brands fa-facebook fa-lg fa-fw"></i>
                                            </a>
                                        @endif
                                        @if (!empty($partner->instagram_url))
                                            <a href="{{ $partner->instagram_url }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#1d3f89]/15 bg-[#f8fbff] text-[#1d3f89] transition hover:bg-[#1d3f89] hover:text-white"
                                                aria-label="Instagram" title="Instagram">
                                                <i class="block leading-none fa-brands fa-instagram fa-lg fa-fw"></i>
                                            </a>
                                        @endif
                                        @if (!empty($partner->linkedin_url))
                                            <a href="{{ $partner->linkedin_url }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#1d3f89]/15 bg-[#f8fbff] text-[#1d3f89] transition hover:bg-[#1d3f89] hover:text-white"
                                                aria-label="LinkedIn" title="LinkedIn">
                                                <i class="block leading-none fa-brands fa-linkedin fa-lg fa-fw"></i>
                                            </a>
                                        @endif
                                        @if (!empty($partner->autre_url))
                                            <a href="{{ $partner->autre_url }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#1d3f89]/15 bg-[#f8fbff] text-[#1d3f89] transition hover:bg-[#1d3f89] hover:text-white"
                                                aria-label="Autre" title="Autre">
                                                <i class="block leading-none fa-solid fa-link fa-lg fa-fw"></i>
                                            </a>
                                        @endif
                                        @if (!empty($partner->phone))
                                            <a href="tel:{{ $partner->phone }}"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#1d3f89]/15 bg-[#f8fbff] text-[#1d3f89] transition hover:bg-[#1d3f89] hover:text-white"
                                                aria-label="Phone" title="Appeler">
                                                <i class="block leading-none fa-solid fa-phone fa-lg fa-fw"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
