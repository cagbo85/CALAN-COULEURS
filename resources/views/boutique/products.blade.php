@extends('layouts.boutique')

@section('title', "Tous les produits - Calan'Couleurs")

@section('content')
    <div class="w-full min-h-screen bg-[#EEF1FF]">

        <!-- Hero compact -->
        <section class="w-full py-12 sm:py-16"
            style="background: linear-gradient(135deg, rgba(29,63,137,0.92) 0%, rgba(119,203,243,0.72) 100%);">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white sm:text-4xl">Tous les produits</h1>
                <p class="mt-3 text-white/90">
                    Explore la collection Calan'Boutique et trouve ta pièce favorite.
                </p>
            </div>
        </section>

        <!-- Breadcrumb -->
        <nav class="px-4 py-4 mx-auto text-sm max-w-7xl sm:px-6 lg:px-8 text-[#1d3f89]/80" aria-label="Breadcrumb">
            <ol class="inline-flex p-0 list-none">
                <li class="flex items-center">
                    <a href="{{ route('boutique.index') }}" class="hover:text-[#1d3f89] transition">Calan'Boutique</a>
                    <i class="fa-solid fa-chevron-right fa-xs mx-2 text-[#1d3f89]/40"></i>
                </li>
                <li class="flex items-center">
                    <span class="font-semibold text-[#1d3f89]">Tous les produits</span>
                </li>
            </ol>
        </nav>

        <section class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

                <!-- Sidebar filtres -->
                <aside class="h-fit lg:col-span-3">
                    <div class="p-5 bg-white border border-[#1d3f89]/10 rounded-2xl shadow-sm lg:sticky lg:top-24">

                        <button type="button" id="filters-toggle"
                            class="flex items-center justify-between w-full transition-colors lg:hidden">
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-[#1d3f89]/15 text-[#1d3f89]">
                                    <i class="fa-solid fa-sliders"></i>
                                </span>
                                <div class="text-left">
                                    <p class="text-base font-bold text-[#1d3f89]">Filtres</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $products->count() }} produit{{ $products->count() > 1 ? 's' : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if (
                                    $count =
                                        collect(request()->only(['sort', 'category', 'badge', 'stock']))->filter()->count() +
                                        count((array) request('size', [])) +
                                        count((array) request('color', [])))
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white rounded-full bg-[#1d3f89]">
                                        {{ $count }}
                                    </span>
                                @endif

                                <i class="fa-solid fa-chevron-down fa-xl text-[#1d3f89] transition-transform duration-300"
                                    id="filters-icon"></i>
                            </div>
                        </button>

                        <div class="hidden lg:block">
                            <p class="text-base font-bold text-[#1d3f89]">
                                Filtres
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $products->count() }} produit{{ $products->count() > 1 ? 's' : '' }}
                                trouvé{{ $products->count() > 1 ? 's' : '' }}
                            </p>
                        </div>

                        <div id="filters-content"
                            class="hidden border-t pt-4 mt-4 border-gray-100 overflow-auto transition-all duration-300 space-y-5 pr-1 lg:block lg:max-h-[70vh]">
                            <form method="GET" action="{{ route('boutique.products') }}" id="filtersForm"
                                class="space-y-5">

                                <!-- Trier -->
                                <div class="filter-group" data-open="true">
                                    <button type="button" onclick="toggleFilter(this)"
                                        class="flex items-center justify-between w-full py-1 text-base font-semibold text-[#1d3f89]">
                                        <span>Trier par</span>
                                        <i class="transition-transform duration-300 fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="mt-3 space-y-2 filter-options">
                                        <label class="flex items-center text-gray-700">
                                            <input type="radio" name="sort" value="price_asc"
                                                class="w-4 h-4 text-[#1d3f89] focus:ring-[#1d3f89]"
                                                {{ request('sort') == 'price_asc' ? 'checked' : '' }}
                                                onchange="this.form.submit()">
                                            <span class="ml-2 text-sm">Prix : faible à élevé</span>
                                        </label>
                                        <label class="flex items-center text-gray-700">
                                            <input type="radio" name="sort" value="price_desc"
                                                class="w-4 h-4 text-[#1d3f89] focus:ring-[#1d3f89]"
                                                {{ request('sort') == 'price_desc' ? 'checked' : '' }}
                                                onchange="this.form.submit()">
                                            <span class="ml-2 text-sm">Prix : élevé à faible</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Couleur -->
                                <div class="filter-group"
                                    data-open="{{ count((array) request('color', [])) ? 'true' : 'false' }}">
                                    <button type="button" onclick="toggleFilter(this)"
                                        class="flex items-center justify-between w-full py-1 text-base font-semibold text-[#1d3f89]">
                                        <div class="flex items-center space-x-2">
                                            <span>Couleur</span>
                                            @if (count((array) request('color', [])))
                                                <span
                                                    class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full bg-[#1d3f89]">
                                                    {{ count((array) request('color', [])) }}
                                                </span>
                                            @endif
                                        </div>
                                        <i class="transition-transform duration-300 fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="hidden mt-3 space-y-2 filter-options">
                                        @foreach ($colors as $color)
                                            <label class="flex items-center text-gray-700 cursor-pointer">
                                                <span class="w-5 h-5 mr-2 border border-gray-300 rounded-full"
                                                    style="background-color: {{ $color->code }};"></span>
                                                <input type="checkbox" name="color[]" value="{{ $color->id }}"
                                                    {{ in_array($color->id, (array) request('color', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-[#1d3f89] rounded focus:ring-[#1d3f89]"
                                                    onchange="this.form.submit()">
                                                <span class="ml-2 text-sm">{{ ucfirst($color->name) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Taille -->
                                <div class="filter-group"
                                    data-open="{{ count((array) request('size', [])) ? 'true' : 'false' }}">
                                    <button type="button" onclick="toggleFilter(this)"
                                        class="flex items-center justify-between w-full py-1 text-base font-semibold text-[#1d3f89]">
                                        <div class="flex items-center space-x-2">
                                            <span>Taille</span>
                                            @if (count((array) request('size', [])))
                                                <span
                                                    class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full bg-[#1d3f89]">
                                                    {{ count((array) request('size', [])) }}
                                                </span>
                                            @endif
                                        </div>
                                        <i class="transition-transform duration-300 fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="hidden mt-3 space-y-2 filter-options">
                                        @foreach ($sizes as $size)
                                            <label class="flex items-center text-gray-700 cursor-pointer">
                                                <input type="checkbox" name="size[]" value="{{ $size->id }}"
                                                    {{ in_array($size->id, (array) request('size', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 rounded text-[#1d3f89] focus:ring-[#1d3f89]"
                                                    onchange="this.form.submit()">
                                                <span class="ml-2 text-sm">{{ $size->label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Catégorie -->
                                <div class="filter-group" data-open="{{ request('category') ? 'true' : 'false' }}">
                                    <button type="button" onclick="toggleFilter(this)"
                                        class="flex items-center justify-between w-full py-1 text-base font-semibold text-[#1d3f89]">
                                        <div class="flex items-center space-x-2">
                                            <span>Catégorie</span>
                                            @if (request('category'))
                                                <span
                                                    class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full bg-[#1d3f89]">1</span>
                                            @endif
                                        </div>
                                        <i class="transition-transform duration-300 fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="hidden mt-3 space-y-2 filter-options">
                                        @foreach ($categories as $cat)
                                            <label class="flex items-center text-gray-700 cursor-pointer">
                                                <input type="radio" name="category" value="{{ $cat }}"
                                                    {{ request('category') == $cat ? 'checked' : '' }}
                                                    class="w-4 h-4 text-[#1d3f89] focus:ring-[#1d3f89]"
                                                    onchange="this.form.submit()">
                                                <span class="ml-2 text-sm">{{ ucfirst($cat) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Collection -->
                                <div class="filter-group" data-open="{{ request('badge') ? 'true' : 'false' }}">
                                    <button type="button" onclick="toggleFilter(this)"
                                        class="flex items-center justify-between w-full py-1 text-base font-semibold text-[#1d3f89]">
                                        <div class="flex items-center space-x-2">
                                            <span>Collection</span>
                                            @if (request('badge'))
                                                <span
                                                    class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full bg-[#1d3f89]">1</span>
                                            @endif
                                        </div>
                                        <i class="transition-transform duration-300 fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="hidden mt-3 space-y-2 filter-options">
                                        @foreach ($badges as $badge)
                                            <label class="flex items-center text-gray-700 cursor-pointer">
                                                <input type="radio" name="badge" value="{{ $badge }}"
                                                    {{ request('badge') == $badge ? 'checked' : '' }}
                                                    class="w-4 h-4 text-[#1d3f89] focus:ring-[#1d3f89]"
                                                    onchange="this.form.submit()">
                                                <span class="ml-2 text-sm">{{ ucfirst($badge) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Disponibilité -->
                                <div class="filter-group" data-open="{{ request('stock') ? 'true' : 'false' }}">
                                    <button type="button" onclick="toggleFilter(this)"
                                        class="flex items-center justify-between w-full py-1 text-base font-semibold text-[#1d3f89]">
                                        <div class="flex items-center space-x-2">
                                            <span>Disponibilité</span>
                                            @if (request('stock'))
                                                <span
                                                    class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full bg-[#1d3f89]">1</span>
                                            @endif
                                        </div>
                                        <i class="transition-transform duration-300 fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="hidden mt-3 space-y-2 filter-options">
                                        <label class="flex items-center text-gray-700 cursor-pointer">
                                            <input type="radio" name="stock" value="in"
                                                {{ request('stock') == 'in' ? 'checked' : '' }}
                                                class="w-4 h-4 text-[#1d3f89] focus:ring-[#1d3f89]"
                                                onchange="this.form.submit()">
                                            <span class="ml-2 text-sm">En stock</span>
                                        </label>
                                        <label class="flex items-center text-gray-700 cursor-pointer">
                                            <input type="radio" name="stock" value="out"
                                                {{ request('stock') == 'out' ? 'checked' : '' }}
                                                class="w-4 h-4 text-[#1d3f89] focus:ring-[#1d3f89]"
                                                onchange="this.form.submit()">
                                            <span class="ml-2 text-sm">En rupture</span>
                                        </label>
                                    </div>
                                </div>

                                @if (request()->hasAny(['sort', 'category', 'size', 'color', 'stock', 'badge']))
                                    <a href="{{ route('boutique.products') }}"
                                        class="inline-flex items-center justify-center w-full gap-1.5 px-4 py-2 mt-2 text-sm font-medium transition bg-gray-100 rounded-lg text-[#1d3f89] hover:bg-gray-200">
                                        <i class="fa-solid fa-xmark fa-lg"></i>
                                        Effacer les filtres
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </aside>

                <!-- Contenu principal -->
                <div class="lg:col-span-9">
                    <div class="p-4 mb-6 bg-white border border-[#1d3f89]/10 rounded-2xl shadow-sm">
                        <div class="flex justify-between">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('boutique.products') }}"
                                    class="px-4 py-2 text-sm font-semibold rounded-full transition {{ !request('badge') ? 'bg-[#1d3f89] text-white' : 'bg-[#e8f5fc] text-[#1d3f89] hover:bg-[#d8eef9]' }}">
                                    Tout
                                </a>
                                <a href="{{ route('boutique.products', ['badge' => 'pull']) }}"
                                    class="px-4 py-2 text-sm font-semibold rounded-full transition {{ request('badge') == 'pull' ? 'bg-[#1d3f89] text-white' : 'bg-[#e8f5fc] text-[#1d3f89] hover:bg-[#d8eef9]' }}">
                                    Pulls
                                </a>
                                <a href="{{ route('boutique.products', ['badge' => 't-shirt']) }}"
                                    class="px-4 py-2 text-sm font-semibold rounded-full transition {{ request('badge') == 't-shirt' ? 'bg-[#1d3f89] text-white' : 'bg-[#e8f5fc] text-[#1d3f89] hover:bg-[#d8eef9]' }}">
                                    T-shirts
                                </a>
                                <a href="{{ route('boutique.products', ['badge' => 'accessoire']) }}"
                                    class="px-4 py-2 text-sm font-semibold rounded-full transition {{ request('badge') == 'accessoire' ? 'bg-[#1d3f89] text-white' : 'bg-[#e8f5fc] text-[#1d3f89] hover:bg-[#d8eef9]' }}">
                                    Accessoires
                                </a>
                            </div>
                            @if (request()->hasAny(['sort', 'category', 'size', 'color', 'stock', 'badge']))
                                <a href="{{ route('boutique.products') }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-[#1d3f89] hover:bg-gray-100 transition rounded-lg">
                                    <i class="fa-solid fa-xmark fa-lg"></i>
                                    Effacer les filtres
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 bg-white border border-[#1d3f89]/10 rounded-2xl shadow-sm">
                        <div class="grid grid-cols-2 gap-5 md:grid-cols-3 xl:grid-cols-4" id="product-grid">
                            @forelse($products as $product)
                                @php
                                    $variants = $uniqueVariants[$product->id] ?? collect();
                                    $firstVariant = $variants->first();
                                @endphp

                                <article
                                    class="overflow-hidden transition-all duration-300 border rounded-xl border-[#1d3f89]/10 bg-[#f9fcfe] hover:shadow-lg"
                                    data-product-id="{{ $product->id }}">
                                    <a href="{{ route('boutique.show', $product->slug) }}" class="block">
                                        <div class="overflow-hidden aspect-square">
                                            <img src="{{ asset($firstVariant ? $firstVariant->image : $product->image) }}"
                                                alt="{{ $product->title }}"
                                                class="object-cover w-full h-full transition-transform duration-300 product-image hover:scale-[1.02]">
                                        </div>

                                        <div class="p-4">
                                            <h3 class="text-base font-semibold leading-snug text-[#1d3f89]">
                                                {{ $product->title }}</h3>
                                            <div class="mt-2 text-sm">
                                                <span
                                                    class="font-bold text-[#1d3f89] text-lg">{{ number_format($product->price, 2) }}€</span>
                                                @if ($product->old_price && $product->old_price > $product->price)
                                                    <span
                                                        class="ml-2 text-gray-400 line-through">{{ number_format($product->old_price, 2) }}€</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>

                                    @if ($variants->count())
                                        <div class="flex px-4 pb-4">
                                            @foreach ($variants as $variant)
                                                <button type="button"
                                                    class="w-5 h-5 mr-2 transition-all border border-gray-300 rounded-full {{ $loop->first ? 'ring-2 ring-[#1d3f89]' : 'hover:scale-110' }}"
                                                    style="background-color: {{ $variant->hex_code }};"
                                                    title="{{ ucfirst($variant->color_name) }}"
                                                    data-color="{{ $variant->color_name }}"
                                                    data-img-url="{{ asset($variant->image) }}"
                                                    onclick="changeColor(this, '{{ $product->id }}')"
                                                    aria-label="Choisir la couleur {{ ucfirst($variant->color_name) }}"></button>
                                            @endforeach
                                        </div>
                                    @endif
                                </article>
                            @empty
                                <div class="py-12 text-center text-gray-500 col-span-full">
                                    Aucun produit trouvé avec ces filtres.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filtersToggle = document.getElementById('filters-toggle');
            const filtersContent = document.getElementById('filters-content');
            const filtersIcon = document.getElementById('filters-icon');
            let isOpen = false;

            filtersToggle.addEventListener('click', () => {
                isOpen = !isOpen;

                if (isOpen) {
                    filtersContent.classList.remove('hidden');
                    filtersContent.style.maxHeight = filtersContent.scrollHeight + 'px';
                    filtersIcon.style.transform = 'rotate(180deg)';
                } else {
                    filtersContent.style.maxHeight = '0';
                    filtersIcon.style.transform = 'rotate(0deg)';

                    setTimeout(() => {
                        filtersContent.classList.add('hidden');
                    }, 300);
                }
            });

            document.querySelectorAll('.filter-group').forEach(function(group) {
                const options = group.querySelector('.filter-options');
                const icon = group.querySelector('i');

                if (!options || !icon) return;

                if (group.dataset.open === 'true') {
                    options.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    options.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });

        function toggleFilter(button) {
            const group = button.closest('.filter-group');
            const options = group?.querySelector('.filter-options');
            const icon = button.querySelector('i');

            if (!group || !options || !icon) return;

            if (group.dataset.open === 'true') {
                options.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
                group.dataset.open = 'false';
            } else {
                options.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
                group.dataset.open = 'true';
            }
        }

        function changeColor(swatch, productId) {
            const card = document.querySelector(`[data-product-id="${productId}"]`);
            if (!card) return;

            const swatches = card.querySelectorAll('[data-color]');
            swatches.forEach(s => s.classList.remove('ring-2', 'ring-[#1d3f89]'));

            swatch.classList.add('ring-2', 'ring-[#1d3f89]');

            const imageUrl = swatch.dataset.imgUrl;
            const productImage = card.querySelector('.product-image');
            const title = card.querySelector('h3')?.textContent || 'Produit';

            if (productImage && imageUrl) {
                productImage.src = imageUrl;
                productImage.alt = `${title} - Couleur ${swatch.dataset.color}`;
            }
        }
    </script>
@endsection
