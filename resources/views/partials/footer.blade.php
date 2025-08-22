<footer class="bg-[#8F1E98] text-white py-12" role="contentinfo" aria-labelledby="footer-heading">
    <div class="container mx-auto px-6">
        {{-- Section supérieure avec logo et navigation --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            {{-- Logo --}}
            <div class="mb-6 md:mb-0 flex items-center gap-3">
                <button id="admin-trigger" type="button"
                    class="inline-flex items-center focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded-md"
                    aria-label="Accès administration (double-clic ou appuyez deux fois sur Entrée/Espace)">
                    <img src="/img/logos/LOGO/Logo-Calan-blanc.png" alt="" aria-hidden="true" class="h-16"
                        title="Logo Calan'Couleurs">
                </button>

                {{-- Lien d’accès admin visible au focus (pour clavier/lecteur d’écran) --}}
                <a href="{{ route('login') }}"
                    class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 bg-white text-[#8F1E98] px-3 py-2 rounded-md shadow"
                    aria-label="Accéder directement à l’administration">
                    Accès administration
                </a>
            </div>

            {{-- Navigation --}}
            <nav aria-label="Liens de pied de page">
                <ul class="flex flex-col sm:flex-row gap-3 sm:gap-8 text-center sm:text-left">
                    <li>
                        <a href="/"
                            class="text-white hover:text-[#FF0F63] font-medium transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('festival') }}"
                            class="text-white hover:text-[#FF0F63] font-medium transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">
                            Le Festival
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('programmation') }}"
                            class="text-white hover:text-[#FF0F63] font-medium transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">
                            Programmation
                        </a>
                    </li>
                    <li>
                        <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Billetterie (ouvre une nouvelle fenêtre)"
                            class="text-white hover:text-[#FF0F63] font-medium transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">
                            Billetterie <span class="sr-only">(nouvelle fenêtre)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="text-white hover:text-[#FF0F63] font-medium transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">
                            Contact
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        {{-- Ligne séparatrice --}}
        <hr class="border-white/20 my-8" aria-hidden="true">

        {{-- Section inférieure avec réseaux sociaux et mentions légales --}}
        <div class="flex flex-col md:flex-row justify-between items-center">
            {{-- Réseaux sociaux --}}
            <ul class="flex space-x-6 mb-6 md:mb-0" aria-label="Réseaux sociaux">
                <li>
                    <a href="https://www.instagram.com/calancouleurs/" target="_blank" rel="noopener noreferrer"
                        aria-label="Instagram Calan’Couleurs (nouvelle fenêtre)"
                        class="text-white hover:text-[#FF0F63] transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="w-6 h-6">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                        <span class="sr-only">Instagram</span>
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/profile.php?id=61555539331779" target="_blank"
                        rel="noopener noreferrer" aria-label="Facebook Calan’Couleurs (nouvelle fenêtre)"
                        class="text-white hover:text-[#FF0F63] transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="w-6 h-6">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                        <span class="sr-only">Facebook</span>
                    </a>
            </ul>

            {{-- Copyright et mentions légales --}}
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-6 text-center sm:text-right">
                <small class="text-sm text-white/80">© 2025 Calan'Couleurs. Tous droits réservés.</small>
                {{-- <a href="#" class="text-sm text-white/70 hover:text-white transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">Mentions légales</a>
                <a href="#" class="text-sm text-white/70 hover:text-white transition duration-300 focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-white/60 rounded">Politique de confidentialité</a> --}}
            </div>
        </div>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trigger = document.getElementById('admin-trigger');
        let clicks = 0;
        let timer = null;

        function goAdmin() {
            window.open('{{ route('login') }}', '_blank', 'noopener,noreferrer');
        }

        trigger.addEventListener('click', () => {
            clicks++;
            if (clicks === 1) {
                timer = setTimeout(() => {
                    clicks = 0;
                }, 500);
            } else if (clicks === 2) {
                clearTimeout(timer);
                clicks = 0;
                goAdmin();
            }
        });

        trigger.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                clicks++;
                if (clicks === 1) {
                    timer = setTimeout(() => {
                        clicks = 0;
                    }, 500);
                } else if (clicks === 2) {
                    clearTimeout(timer);
                    clicks = 0;
                    goAdmin();
                }
            }
        });
    });
</script>
