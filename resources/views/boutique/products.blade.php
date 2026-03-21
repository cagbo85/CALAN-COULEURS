@extends('layouts.boutique')

@section('title', "Tous les produits - Calan'Couleurs")

@section('content')
    <!-- Breadcrumb -->
    <nav class="p-2 text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('boutique.index') }}" class="hover:text-[#8F1E98]">La Calan'Boutique</a>
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="text-[#8F1E98] font-semibold">Tous les produits</span>
            </li>
        </ol>
    </nav>
    <section class="w-full px-2 sm:px-4 py-8 flex flex-row justify-center space-x-2">
        <!-- COLONNE GAUCHE : SIDEBAR (Filtres) -->
        <aside class="bg-white w-80 p-6 rounded-xl shadow-lg flex flex-col">
            <!-- Compteur de Produits Dynamique -->
            <div class="pb-4 mb-4 border-b border-gray-200 text-center flex-shrink-0">
                <p class="text-lg font-bold text-gray-800" id="product-count">
                    {{ $products->count() }} produit{{ $products->count() > 1 ? 's' : '' }}
                    trouvé{{ $products->count() > 1 ? 's' : '' }}
                </p>
            </div>

            <!-- Filtres dynamiques -->
            <form method="GET" action="{{ route('boutique.products') }}" id="filtersForm"
                class="space-y-6 flex-1 overflow-y-auto">
                <!-- Trier par -->
                <div class="filter-group" data-open="true">
                    <button type="button" onclick="toggleFilter(this)"
                        class="flex justify-between items-center w-full py-2 text-lg font-semibold text-gray-800 hover:text-[#8F1E98] transition">
                        <span>Trier par</span>
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>
                    <div class="filter-options space-y-2 mt-2">
                        <label class="flex items-center text-gray-600">
                            <input type="radio" name="sort" value="price_asc"
                                class="h-4 w-4 text-[#8F1E98] focus:ring-[#8F1E98]"
                                {{ request('sort') == 'price_asc' ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="ml-2 text-sm">Prix : faible à élevé</span>
                        </label>
                        <label class="flex items-center text-gray-600">
                            <input type="radio" name="sort" value="price_desc"
                                class="h-4 w-4 text-[#8F1E98] focus:ring-[#8F1E98]"
                                {{ request('sort') == 'price_desc' ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="ml-2 text-sm">Prix : élevé à faible</span>
                        </label>
                    </div>
                </div>

                <!-- Couleur -->
                <div class="filter-group" data-open="{{ count((array) request('color', [])) ? 'true' : 'false' }}">
                    <button type="button" onclick="toggleFilter(this)"
                        class="flex justify-between items-center w-full py-2 text-lg font-semibold text-gray-800 hover:text-[#8F1E98] transition">
                        <div class="flex items-center space-x-2">
                            <span>Couleur</span>
                            @if (count((array) request('color', [])))
                                <span
                                    class="inline-flex items-center justify-center text-xs font-bold bg-[#8F1E98] text-white rounded-full w-5 h-5">
                                    {{ count((array) request('color', [])) }}
                                </span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="filter-options space-y-2 mt-2 hidden">
                        @foreach ($colors as $color)
                            <label class="flex items-center text-gray-600 cursor-pointer">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 mr-2 bg-[{{ $color->code }}]">
                                </div>
                                <input type="checkbox" name="color[]" value="{{ $color->id }}"
                                    {{ in_array($color->id, (array) request('color', [])) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span class="ml-2 text-sm">{{ ucfirst($color->name) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Taille -->
                <div class="filter-group" data-open="{{ count((array) request('size', [])) ? 'true' : 'false' }}">
                    <button type="button" onclick="toggleFilter(this)"
                        class="flex justify-between items-center w-full py-2 text-lg font-semibold text-gray-800 hover:text-[#8F1E98] transition">
                        <div class="flex items-center space-x-2">
                            <span>Taille</span>
                            @if (count((array) request('size', [])))
                                <span
                                    class="ml-2 inline-flex items-center justify-center text-xs font-bold bg-[#8F1E98] text-white rounded-full w-5 h-5">
                                    {{ count((array) request('size', [])) }}
                                </span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="filter-options space-y-2 mt-2 hidden">
                        @foreach ($sizes as $size)
                            <label class="flex items-center text-gray-600 cursor-pointer">
                                <input type="checkbox" name="size[]" value="{{ $size->id }}"
                                    {{ in_array($size->id, (array) request('size', [])) ? 'checked' : '' }}
                                    class="form-checkbox rounded text-[#8F1E98] h-4 w-4" onchange="this.form.submit()">
                                <span class="ml-2 text-sm">{{ $size->label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Catégorie -->
                <div class="filter-group" data-open="{{ request('category') ? 'true' : 'false' }}">
                    <button type="button" onclick="toggleFilter(this)"
                        class="flex justify-between items-center w-full py-2 text-lg font-semibold text-gray-800 hover:text-[#8F1E98] transition">
                        <div class="flex items-center space-x-2">
                            <span>Catégorie</span>
                            @if (request('category'))
                                <span
                                    class="ml-2 inline-flex items-center justify-center text-xs font-bold bg-[#8F1E98] text-white rounded-full w-5 h-5">1</span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="filter-options space-y-2 mt-2 hidden">
                        @foreach ($categories as $cat)
                            <label class="flex items-center text-gray-600 cursor-pointer">
                                <input type="radio" name="category" value="{{ $cat }}"
                                    {{ request('category') == $cat ? 'checked' : '' }}
                                    class="form-radio text-[#8F1E98] h-4 w-4" onchange="this.form.submit()">
                                <span class="ml-2 text-sm">{{ ucfirst($cat) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Badge / Collection -->
                <div class="filter-group" data-open="{{ request('badge') ? 'true' : 'false' }}">
                    <button type="button" onclick="toggleFilter(this)"
                        class="flex justify-between items-center w-full py-2 text-lg font-semibold text-gray-800 hover:text-[#8F1E98] transition">
                        <div class="flex items-center space-x-2">
                            <span>Collection</span>
                            @if (request('badge'))
                                <span
                                    class="ml-2 inline-flex items-center justify-center text-xs font-bold bg-[#8F1E98] text-white rounded-full w-5 h-5">1</span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="filter-options space-y-2 mt-2 hidden">
                        @foreach ($badges as $badge)
                            <label class="flex items-center text-gray-600 cursor-pointer">
                                <input type="radio" name="badge" value="{{ $badge }}"
                                    {{ request('badge') == $badge ? 'checked' : '' }}
                                    class="form-radio text-[#8F1E98] h-4 w-4" onchange="this.form.submit()">
                                <span class="ml-2 text-sm">{{ ucfirst($badge) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- <!-- 4. Genre (Checkboxes avec compteur) -->
                <div class="filter-group" data-open="{{ count((array) request('color', [])) ? 'true' : 'false' }}">
                    <button onclick="toggleFilter(this)"
                        class="flex justify-between items-center w-full py-2 text-lg font-semibold text-gray-800 hover:text-[#8F1E98] transition">
                        <span>Genre</span>
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="filter-options space-y-2 mt-2 hidden">
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" class="rounded h-4 w-4 text-[#8F1E98] focus:ring-[#8F1E98]">
                            <span class="ml-2 text-sm">Unisex</span>
                            <span class="ml-auto text-xs text-gray-500">(8)</span>
                        </label>
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" class="rounded h-4 w-4 text-[#8F1E98] focus:ring-[#8F1E98]">
                            <span class="ml-2 text-sm">Femme</span>
                            <span class="ml-auto text-xs text-gray-500">(4)</span>
                        </label>
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" class="rounded h-4 w-4 text-[#8F1E98] focus:ring-[#8F1E98]">
                            <span class="ml-2 text-sm">Homme</span>
                            <span class="ml-auto text-xs text-gray-500">(6)</span>
                        </label>
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" class="rounded h-4 w-4 text-[#8F1E98] focus:ring-[#8F1E98]">
                            <span class="ml-2 text-sm">Enfant</span>
                            <span class="ml-auto text-xs text-gray-500">(2)</span>
                        </label>
                    </div>
                </div> --}}

                <!-- Disponibilité -->
                <div class="filter-group" data-open="{{ request('stock') ? 'true' : 'false' }}">
                    <button type="button" onclick="toggleFilter(this)"
                        class="flex justify-between items-center w-full py-2 text-lg font-semibold text-gray-800 hover:text-[#8F1E98] transition">
                        <div class="flex items-center space-x-2">
                            <span>Disponibilité</span>
                            @if (count((array) request('stock', [])))
                                <span
                                    class="ml-2 inline-flex items-center justify-center text-xs font-bold bg-[#8F1E98] text-white rounded-full w-5 h-5">
                                    {{ count((array) request('stock', [])) }}
                                </span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="filter-options space-y-2 mt-2 hidden">
                        <label class="flex items-center text-gray-600 cursor-pointer">
                            <input type="checkbox" name="stock" value="in"
                                {{ request('stock') == 'in' ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="ml-2 text-sm">En stock</span>
                        </label>
                        <label class="flex items-center text-gray-600 cursor-pointer">
                            <input type="checkbox" name="stock" value="out"
                                {{ request('stock') == 'out' ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="ml-2 text-sm">En rupture de stock</span>
                        </label>
                    </div>
                </div>

                @if (request()->hasAny(['sort', 'category', 'size', 'color', 'stock', 'badge']))
                    <a href="{{ route('boutique.products') }}"
                        class="mt-6 w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 rounded-lg hover:text-[#FF0F63] hover:bg-gray-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Effacer les filtres
                    </a>
                @endif
            </form>
        </aside>
        <section class="flex-1 flex flex-col" id="main-content">
            <!-- TOOLBAR HORIZONTALE (Sous la Navbar) -->
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-xl shadow-sm mb-6">
                <!-- Badges de Catégorie -->
                <div class="flex flex-wrap gap-2 mb-4 md:mb-0">
                    <a href="{{ route('boutique.products') }}"
                        class="px-4 py-2 text-sm font-semibold rounded-full shadow-md cursor-pointer transition
                {{ !request('badge') ? 'text-white bg-[#8F1E98]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Tout
                    </a>
                    <a href="{{ route('boutique.products', ['badge' => 'pull']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-full cursor-pointer transition
                {{ request('badge') == 'pull' ? 'text-white bg-[#8F1E98]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Pulls
                    </a>
                    <a href="{{ route('boutique.products', ['badge' => 't-shirt']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-full cursor-pointer transition
                {{ request('badge') == 't-shirt' ? 'text-white bg-[#8F1E98]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        T-shirts
                    </a>
                    <a href="{{ route('boutique.products', ['badge' => 'accessoire']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-full cursor-pointer transition
                {{ request('badge') == 'accessoire' ? 'text-white bg-[#8F1E98]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Accessoires
                    </a>
                </div>

                <!-- Bouton Effacer Filtres -->
                @if (request()->hasAny(['sort', 'category', 'size', 'color', 'stock', 'badge']))
                    <a href="{{ route('boutique.products') }}"
                        class="flex items-center text-sm font-medium text-gray-500 hover:text-[#FF0F63] transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Effacer les filtres
                    </a>
                @endif
            </div>
            <div class="flex-1 bg-white p-6 rounded-xl shadow-lg">
                <!-- GRILLE DE PRODUITS -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="product-grid">
                    @forelse($products as $product)
                        <div class="product-card bg-gray-50 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl cursor-pointer"
                            data-product-id="{{ $product->id }}">
                            <a href="{{ route('boutique.show', $product->slug) }}">
                                @php
                                    $variants = $uniqueVariants[$product->id] ?? collect();
                                    $firstVariant = $variants->first();
                                @endphp
                                <img src="{{ asset($firstVariant ? $firstVariant->image : $product->image) }}"
                                    alt="{{ $product->title }}" class="w-full h-auto object-cover product-image">
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800">{{ $product->title }}</h3>
                                    <div class="mt-1 text-sm">
                                        <span
                                            class="font-bold text-[#FF0F63] text-xl">{{ number_format($product->price, 2) }}€</span>
                                        @if ($product->old_price && $product->old_price > $product->price)
                                            <span
                                                class="text-gray-400 line-through ml-2">{{ number_format($product->old_price, 2) }}€</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <!-- Sélecteur de couleur -->
                            @if ($variants->count())
                                <div class="flex px-4 pb-4">
                                    @foreach ($variants as $variant)
                                        <div class="w-5 h-5 rounded-full border-2 cursor-pointer transition-all mr-2 {{ $loop->first ? 'ring-2 ring-[#8F1E98]' : 'border-gray-300 hover:scale-110' }} bg-[{{ $variant->hex_code }}]"
                                            title="{{ ucfirst($variant->color_name) }}" data-color="{{ $variant->color_name }}"
                                            data-img-url="{{ asset($variant->image) }}"
                                            onclick="changeColor(this, '{{ $product->id }}')"></div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-4 text-center text-gray-400 py-12">Aucun produit trouvé.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ouvrir les groupes de filtres qui ont des options sélectionnées
            document.querySelectorAll('.filter-group').forEach(function(group) {
                const options = group.querySelector('.filter-options');
                const icon = group.querySelector('svg');
                if (group.dataset.open === 'true') {
                    options.classList.remove('hidden');
                    if (icon) {
                        icon.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>';
                    }
                }
            });
        });

        // Fonction pour ouvrir/fermer les groupes de filtres
        function toggleFilter(button) {
            const group = button.closest('.filter-group');
            const options = group.querySelector('.filter-options');
            const icon = button.querySelector('svg');

            if (group.dataset.open === 'true') {
                // Fermer
                options.classList.add('hidden');
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>';
                group.dataset.open = 'false';
            } else {
                // Ouvrir
                options.classList.remove('hidden');
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>';
                group.dataset.open = 'true';
            }
        }

        // Fonction pour changer la couleur des produits
        function changeColor(swatch, productId) {
            // Désélectionner toutes les pastilles de ce produit
            const card = document.querySelector(`[data-product-id="${productId}"]`);
            if (!card) return;

            const swatches = card.querySelectorAll('[data-color]');
            swatches.forEach(s => {
                s.classList.remove('ring-2', 'ring-[#8F1E98]');
                s.classList.add('border-gray-300', 'hover:scale-110');
            });

            // Sélectionner la nouvelle pastille
            swatch.classList.add('ring-2', 'ring-[#8F1E98]');
            swatch.classList.remove('border-gray-300', 'hover:scale-110');

            // Mettre à jour l'image
            const imageUrl = swatch.dataset.imgUrl;
            const productImage = card.querySelector('.product-image');
            if (productImage && imageUrl) {
                productImage.src = imageUrl;
                productImage.alt = `${card.querySelector('h3').textContent} - Couleur ${swatch.dataset.color}`;
            }
        }
    </script>
@endsection
