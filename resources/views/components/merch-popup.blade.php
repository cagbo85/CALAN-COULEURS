<div id="merchPopup" class="fixed inset-0 z-[80] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="relative flex items-center justify-center min-h-full p-4 sm:p-6">
        <div
            class="relative w-full max-w-3xl overflow-hidden rounded-3xl border border-white/40 bg-white shadow-[0_25px_80px_rgba(15,23,42,0.35)]">
            <button id="closeMerchPopup" type="button"
                class="absolute right-4 top-4 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-gray-600 shadow-sm transition hover:bg-white hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1d3f89]"
                aria-label="Fermer la fenêtre">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </button>

            <div class="flex flex-col">
                <div class="relative min-h-[220px] overflow-hidden p-6 sm:p-8 text-white">
                    <div class="relative flex flex-col justify-between h-full">
                        <div>
                            <span
                                class="inline-flex items-center rounded-full border border-[#77cbf3]/20 bg-[#1d3f89]/10 text-[#1d3f89] px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                                Nouveau
                            </span>

                            <h1 class="text-center mt-5 mb-4 text-4xl font-bold sm:text-5xl text-[#1d3f89]">
                                Découvre le merch officiel
                            </h1>

                            <p class="max-w-2xl mx-auto mt-4 text-lg text-center text-gray-600">
                                Pulls, t-shirts et souvenirs du festival, tout ça pour prolonger l'ambiance
                                Calan'Couleurs avec vous !
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 mt-8 sm:flex-row">
                        <a href="{{ route('boutique.index') }}"
                            class="flex-1 block text-center gap-2 rounded-xl bg-[#1d3f89] px-5 py-3 font-bold text-white transition hover:bg-[#16306a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1d3f89]">
                            Voir le merch
                            <span aria-hidden="true">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>

                        <button id="closeMerchPopupSecondary" type="button"
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-[#1d3f89]/15 bg-white px-5 py-3 font-semibold text-[#1d3f89] transition hover:bg-[#f8f9fc] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1d3f89]">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
