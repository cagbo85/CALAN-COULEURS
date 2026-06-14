@extends('layouts.boutique')

@section('title', $product->title . ' - Boutique Calan\'Couleurs')

@section('content')
    <div class="w-full bg-[#EEF1FF]">

        <!-- Breadcrumb -->
        <nav class="px-4 py-4 mx-auto text-sm max-w-7xl sm:px-6 lg:px-8 text-[#1d3f89]/80" aria-label="Breadcrumb">
            <ol class="inline-flex p-0 list-none">
                <li class="flex items-center">
                    <a href="{{ route('boutique.index') }}" class="transition hover:text-[#1d3f89]">Calan'Boutique</a>
                    <i class="fa-solid fa-chevron-right fa-xs mx-2 text-[#1d3f89]/40"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('boutique.products') }}" class="transition hover:text-[#1d3f89]">Tous les produits</a>
                    <i class="fa-solid fa-chevron-right fa-xs mx-2 text-[#1d3f89]/40"></i>
                </li>
                <li class="flex items-center">
                    <span class="font-semibold text-[#1d3f89]">{{ $product->title }}</span>
                </li>
            </ol>
        </nav>

        <section class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-start grid-cols-1 gap-8 lg:grid-cols-12">
                <!-- COLONNE GAUCHE : Le Carrousel (Gros visuel + vignettes à gauche) (5/12) -->
                <div class="flex gap-4 lg:col-span-7" id="product-carousel" data-images='@json($carouselImages)'>
                    <div class="flex-col flex-shrink-0 hidden w-16 gap-2 sm:flex" id="carousel-thumbs">
                        @foreach ($carouselImages as $index => $img)
                            <button type="button"
                                class="overflow-hidden rounded border transition {{ $index === 0 ? 'border-[#1d3f89] border-2' : 'border-gray-300 opacity-70 hover:opacity-100' }}"
                                data-index="{{ $index }}" aria-label="Voir image {{ $index + 1 }}">
                                <img src="{{ asset($img) }}" class="object-cover w-full h-20"
                                    alt="{{ $product->title }} miniature {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>

                    <div class="relative flex-1 overflow-hidden bg-white rounded-lg shadow-sm">
                        <img id="carousel-main-image" src="{{ asset($carouselImages[0] ?? $product->image) }}"
                            class="w-full h-[550px] object-cover" alt="{{ $product->title }}">

                        <button type="button" id="carousel-prev"
                            class="absolute p-2 -translate-y-1/2 rounded-full left-3 top-1/2 bg-white/60 hover:bg-white/80">
                            <i class="fa-solid fa-chevron-left fa-xl text-[#1d3f89]"></i>
                        </button>

                        <button type="button" id="carousel-next"
                            class="absolute p-2 -translate-y-1/2 rounded-full right-3 top-1/2 bg-white/60 hover:bg-white/80">
                            <i class="fa-solid fa-chevron-right fa-xl text-[#1d3f89]"></i>
                        </button>
                    </div>
                </div>

                <!-- COLONNE DROITE : Infos Produits & Boutons d'Achat (5/12) -->
                <div class="flex flex-col justify-between h-full space-y-4 lg:col-span-5">

                    <!-- Titre et Prix -->
                    <div class="mb-0">
                        <h1 class="text-2xl font-bold text-[#1d3f89] tracking-tight">{{ $product->title }}</h1>
                        @if ($product->description)
                            <p class="mt-1 text-sm text-gray-600">{{ $product->description }}</p>
                        @endif
                        <div class="flex flex-row items-center gap-2 mt-3">
                            <div class="text-2xl font-extrabold text-[#1d3f89]">
                                {{ number_format($product->price, 2) }}€</div>
                            @if ($product->old_price && $product->old_price > $product->price)
                                <div class="text-sm text-gray-500 line-through">
                                    {{ number_format($product->old_price, 2) }}€</div>
                                <div class="text-sm font-bold text-red-500">
                                    -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="variant-picker" class="space-y-4">
                        <input type="hidden" name="variant_id" id="selected-variant-id">

                        <div>
                            <span class="block mb-2 text-sm font-bold tracking-wide text-gray-700 uppercase">Couleur</span>
                            <div class="flex flex-wrap gap-2" id="color-options">
                                @foreach ($uniqueVariants as $variantColor)
                                    <button type="button"
                                        class="color-option inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-800 transition hover:border-[#1d3f89]"
                                        data-color-id="{{ $variantColor->color_id }}"
                                        data-color-name="{{ $variantColor->color_name }}"
                                        data-color-hex="{{ $variantColor->hex_code }}"
                                        data-color-image="{{ $variantColor->image }}"
                                        aria-label="Choisir la couleur {{ ucfirst($variantColor->color_name) }}">
                                        <span class="w-3 h-3 border border-gray-300 rounded-full"
                                            style="background-color: {{ $variantColor->hex_code }};"></span>
                                        {{ ucfirst($variantColor->color_name) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <span class="block mb-2 text-sm font-bold tracking-wide text-gray-700 uppercase">Taille</span>
                            <div class="flex flex-wrap gap-2" id="size-options">
                                @foreach ($uniqueSizes as $size)
                                    <button type="button"
                                        class="size-option w-14 h-10 flex items-center justify-center border border-gray-300 bg-white text-gray-700 font-medium rounded-md text-sm transition hover:border-[#1d3f89]"
                                        data-size-id="{{ $size->id }}" data-size-label="{{ $size->label }}">
                                        {{ $size->label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div id="stock-box" class="hidden px-4 py-2.5 rounded-md text-sm font-medium border"></div>

                        <div class="flex flex-col gap-1">
                            <label for="quantity" class="text-xs font-bold text-gray-600 uppercase">Quantité</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1"
                                max="10"
                                class="w-24 border border-gray-300 px-3 py-2 rounded-md bg-white text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1d3f89]"
                                disabled>
                        </div>

                        <button type="button" id="add-to-cart-btn"
                            class="w-full px-6 py-4 text-sm font-bold tracking-wide text-center text-white uppercase transition bg-gray-400 rounded-lg shadow cursor-not-allowed"
                            disabled>
                            Choisir une couleur et une taille
                        </button>
                    </div>

                    <hr class="border-gray-200">

                    <!-- Accordéons Informations produit (Style ASOS, direct dans le flux) -->
                    <div class="space-y-2">
                        <div class="border-b border-gray-200 summary-group" data-open="false">
                            <button type="button" class="w-full py-2 summary-toggle">
                                <div
                                    class="flex items-center justify-between font-bold text-[#1d3f89] text-sm uppercase tracking-wide">
                                    Matière et composition
                                    <i
                                        class="summary-icon fa-solid fa-chevron-down fa-xl text-[#1d3f89] transition-transform duration-300"></i>
                                </div>
                            </button>
                            <div class="hidden pb-2 pl-1 text-sm leading-relaxed text-left text-gray-600 summary-content">
                                @if ($product->badge == 't-shirt')
                                    <p>100% coton bio certifié GOTS. Tissu doux et respirant, idéal pour un port
                                        quotidien.</p>
                                @elseif($product->badge == 'pull')
                                    <p>80% coton, 20% polyester recyclé. Maille douce et chaude, parfaite pour les
                                        saisons fraîches.</p>
                                @else
                                    <p>Matériaux de qualité premium, sélectionnés pour leur durabilité et leur confort.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="border-b border-gray-200 summary-group" data-open="false">
                            <button type="button" class="w-full py-2 summary-toggle">
                                <div
                                    class="flex items-center justify-between font-bold text-[#1d3f89] text-sm uppercase tracking-wide">
                                    Conseils d'entretien
                                    <i
                                        class="summary-icon fa-solid fa-chevron-down fa-xl text-[#1d3f89] transition-transform duration-300"></i>
                                </div>
                            </button>
                            <div class="hidden pb-2 pl-1 text-sm leading-relaxed text-left text-gray-600 summary-content">
                                <ul class="space-y-1">
                                    <li><i class="fa-solid fa-circle fa-2xs text-[#1d3f89] mr-2"></i> Lavage en machine à
                                        30°C maximum</li>
                                    <li><i class="fa-solid fa-circle fa-2xs text-[#1d3f89] mr-2"></i> Séchage à l'air libre
                                        de préférence</li>
                                    <li><i class="fa-solid fa-circle fa-2xs text-[#1d3f89] mr-2"></i> Repassage à
                                        température moyenne</li>
                                    <li><i class="fa-solid fa-circle fa-2xs text-[#1d3f89] mr-2"></i> Ne pas utiliser d'eau
                                        de javel</li>
                                </ul>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 summary-group" data-open="false">
                            <button type="button" class="w-full py-2 summary-toggle">
                                <div
                                    class="flex items-center justify-between font-bold text-[#1d3f89] text-sm uppercase tracking-wide">
                                    À propos de la livraison
                                    <i
                                        class="summary-icon fa-solid fa-chevron-down fa-xl text-[#1d3f89] transition-transform duration-300"></i>
                                </div>
                            </button>
                            <div class="hidden pb-2 pl-1 text-sm leading-relaxed text-left text-gray-600 summary-content">
                                <ul class="space-y-2">
                                    <li><i class="fa-solid fa-circle fa-2xs text-[#1d3f89] mr-2"></i><strong>Livraison
                                            standard :</strong> 3-5 jours ouvrés (gratuite dès 50€)</li>
                                    <li><i class="fa-solid fa-circle fa-2xs text-[#1d3f89] mr-2"></i><strong>Retrait
                                            festival :</strong> Disponible sur site (gratuit)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const root = document.getElementById('product-carousel');
            if (!root) return;

            const images = JSON.parse(root.dataset.images || '[]');
            if (!images.length) return;

            let index = 0;
            const main = document.getElementById('carousel-main-image');
            const prev = document.getElementById('carousel-prev');
            const next = document.getElementById('carousel-next');
            const thumbs = Array.from(root.querySelectorAll('[data-index]'));

            function normalizePath(path) {
                return String(path || '').replace(/^\/+/, '');
            }

            function getFileName(path) {
                const p = normalizePath(path);
                const parts = p.split('/');
                return parts[parts.length - 1] || '';
            }

            function render() {
                if (!images[index]) return;
                main.src = '/' + normalizePath(images[index]);

                thumbs.forEach((btn, i) => {
                    btn.classList.toggle('border-2', i === index);
                    btn.classList.toggle('border-[#1d3f89]', i === index);
                    btn.classList.toggle('opacity-70', i !== index);
                });
            }

            function syncCarouselToPath(path) {
                const normalized = normalizePath(path);
                const targetName = getFileName(normalized);

                const foundIndex = images.findIndex((img) => {
                    const imgNorm = normalizePath(img);
                    if (imgNorm === normalized) return true;
                    return getFileName(imgNorm) === targetName;
                });

                if (foundIndex === -1) {
                    return false;
                }

                index = foundIndex;
                render();
                return true;
            }

            prev?.addEventListener('click', () => {
                index = (index - 1 + images.length) % images.length;
                render();
            });

            next?.addEventListener('click', () => {
                index = (index + 1) % images.length;
                render();
            });

            thumbs.forEach((btn) => {
                btn.addEventListener('click', () => {
                    index = Number(btn.dataset.index || 0);
                    render();
                });
            });

            render();

            window.productCarousel = {
                syncToPath: syncCarouselToPath
            };
        });

        document.addEventListener('DOMContentLoaded', function() {
            const variants = @json($allVariants);
            const stockTexts = @json($stockTexts);

            const colorButtons = Array.from(document.querySelectorAll('.color-option'));
            const sizeButtons = Array.from(document.querySelectorAll('.size-option'));

            const stockBox = document.getElementById('stock-box');
            const quantityInput = document.getElementById('quantity');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const variantInput = document.getElementById('selected-variant-id');

            const productId = @json($product->id);

            let isAddingToCart = false;
            let selectedColorId = null;
            let selectedSizeId = null;
            let hasUserSelection = false;
            let lastSyncedColorId = null;

            function toInt(v) {
                const n = Number(v);
                return Number.isNaN(n) ? null : n;
            }

            function findVariant(colorId, sizeId) {
                return variants.find((v) =>
                    toInt(v.color_id) === toInt(colorId) &&
                    toInt(v.size_id) === toInt(sizeId)
                );
            }

            function paintStock(text, state) {
                stockBox.classList.remove(
                    'hidden',
                    'bg-red-50', 'border-red-200', 'text-red-700',
                    'bg-orange-50', 'border-orange-200', 'text-orange-700',
                    'bg-green-50', 'border-green-200', 'text-green-700'
                );

                if (state === 'out') {
                    stockBox.classList.add('bg-red-50', 'border-red-200', 'text-red-700');
                } else if (state === 'low') {
                    stockBox.classList.add('bg-orange-50', 'border-orange-200', 'text-orange-700');
                } else {
                    stockBox.classList.add('bg-green-50', 'border-green-200', 'text-green-700');
                }

                stockBox.textContent = text;
            }

            function paintActiveButtons() {
                colorButtons.forEach((btn) => {
                    const active = toInt(btn.dataset.colorId) === toInt(selectedColorId);
                    btn.classList.toggle('bg-[#1d3f89]', active);
                    btn.classList.toggle('text-white', active);
                    btn.classList.toggle('border-[#1d3f89]', active);
                    btn.classList.toggle('bg-white', !active);
                    btn.classList.toggle('text-gray-800', !active);
                    btn.classList.toggle('border-gray-300', !active);
                });

                sizeButtons.forEach((btn) => {
                    const active = toInt(btn.dataset.sizeId) === toInt(selectedSizeId);
                    btn.classList.toggle('border-2', active);
                    btn.classList.toggle('border-[#1d3f89]', active);
                    btn.classList.toggle('bg-[#1d3f89]', active);
                    btn.classList.toggle('text-white', active);

                    if (!active) {
                        btn.classList.remove('bg-[#1d3f89]', 'text-white', 'border-2', 'border-[#1d3f89]');
                    }
                });
            }

            function refreshSelectionState() {
                const variant = findVariant(selectedColorId, selectedSizeId);
                const hasVariant = !!variant;
                const qty = hasVariant ? (toInt(variant.quantity) ?? 0) : 0;
                const inStock = qty > 0;

                // Toujours garder l'id de variante si une combinaison couleur+taille existe
                variantInput.value = hasVariant ? String(variant.id) : '';

                if (hasVariant && inStock) {
                    quantityInput.disabled = false;
                    quantityInput.max = String(Math.min(10, qty));

                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    addToCartBtn.classList.add('bg-[#1d3f89]', 'hover:bg-[#16336f]');
                    addToCartBtn.textContent = 'Ajouter au panier';

                    if (qty <= 3) {
                        paintStock('Plus que ' + qty + ' en stock !', 'low');
                    } else if (qty <= 10) {
                        paintStock(qty + ' articles en stock', 'in');
                    } else {
                        paintStock('En stock', 'in');
                    }
                } else if (hasVariant) {
                    quantityInput.disabled = true;
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.remove('bg-[#1d3f89]', 'hover:bg-[#16336f]');
                    addToCartBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    addToCartBtn.textContent = 'Rupture';
                    paintStock('Rupture de stock', 'out');
                } else {
                    quantityInput.disabled = true;
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.remove('bg-[#1d3f89]', 'hover:bg-[#16336f]');
                    addToCartBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    addToCartBtn.textContent = 'Indisponible';
                    paintStock('Variante indisponible', 'out');
                }
            }

            function refreshSizeAvailability() {
                sizeButtons.forEach((btn) => {
                    const sizeId = btn.dataset.sizeId;
                    const variant = findVariant(selectedColorId, sizeId);
                    const exists = !!variant;
                    const inStock = exists && (toInt(variant.quantity) > 0);

                    btn.classList.remove('opacity-40', 'cursor-not-allowed', 'line-through');
                    btn.disabled = false;
                    btn.title = '';

                    if (!exists) {
                        btn.disabled = true;
                        btn.classList.add('opacity-40', 'cursor-not-allowed');
                        btn.title = 'Indisponible pour cette couleur';
                    } else if (!inStock) {
                        btn.disabled = true;
                        btn.classList.add('opacity-40', 'cursor-not-allowed', 'line-through');
                        btn.title = 'Rupture de stock';
                    }
                });

                const currentVariant = findVariant(selectedColorId, selectedSizeId);
                const currentInStock = currentVariant && toInt(currentVariant.quantity) > 0;

                if (!currentVariant || !currentInStock) {
                    const firstAvailable = sizeButtons.find((btn) => {
                        const variant = findVariant(selectedColorId, btn.dataset.sizeId);
                        return variant && toInt(variant.quantity) > 0;
                    });
                    selectedSizeId = firstAvailable ? firstAvailable.dataset.sizeId : null;
                }

                paintActiveButtons();
                refreshSelectionState();
            }

            function setAddToCartLoadingState(loading) {
                isAddingToCart = loading;
                addToCartBtn.disabled = loading || !variantInput.value;
                addToCartBtn.classList.toggle('opacity-70', loading);
                addToCartBtn.textContent = loading ? 'Ajout en cours...' : 'Ajouter au panier';
            }

            addToCartBtn.addEventListener('click', async () => {
                if (isAddingToCart) return;
                if (!variantInput.value) return;

                const qty = Number(quantityInput.value || 1);
                const payload = {
                    product_id: productId,
                    variant_id: Number(variantInput.value),
                    quantity: qty
                };

                setAddToCartLoadingState(true);

                let shouldRefreshInFinally = true;

                try {
                    const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '';

                    if (!csrfToken) {
                        paintStock('Session expirée. Recharge la page.', 'out');
                        return;
                    }

                    const response = await fetch('{{ route('boutique.add-to-cart', [], true) }}', {
                        method: 'POST',
                        credentials: 'same-origin',
                        cache: 'no-store',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload)
                    });

                    const contentType = response.headers.get('content-type') || '';
                    const data = contentType.includes('application/json') ?
                        await response.json() :
                        null;

                    if (response.status === 419) {
                        paintStock('Session expirée. Recharge la page.', 'out');
                        return;
                    }

                    if (!response.ok || !data?.success) {
                        const msg = data?.error || 'Impossible d’ajouter au panier.';
                        paintStock(msg, 'out');
                        return;
                    }

                    if (typeof window.updateCartCounter === 'function') {
                        window.updateCartCounter(data.cart_count || 0);
                    }
                    if (typeof window.loadCartPanelContent === 'function') {
                        window.loadCartPanelContent();
                    }

                    const isMobile = window.matchMedia('(max-width: 767px)').matches;
                    if (!isMobile && typeof window.openCartPanel === 'function') {
                        window.openCartPanel();
                    }

                    shouldRefreshInFinally = false;
                    addToCartBtn.textContent = 'Ajouté !';

                    setTimeout(() => {
                        refreshSelectionState();
                    }, 900);

                } catch (e) {
                    paintStock('Erreur réseau, réessaie.', 'out');
                } finally {
                    addToCartBtn.classList.remove('opacity-70');
                    isAddingToCart = false;

                    if (shouldRefreshInFinally) {
                        refreshSelectionState();
                    }
                }
            });

            colorButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    hasUserSelection = true;
                    selectedColorId = btn.dataset.colorId;
                    lastSyncedColorId = null;
                    refreshSizeAvailability();
                });
            });

            sizeButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    if (btn.disabled) return;
                    hasUserSelection = true;
                    selectedSizeId = btn.dataset.sizeId;
                    paintActiveButtons();
                    refreshSelectionState();
                });
            });

            if (colorButtons.length) {
                selectedColorId = colorButtons[0].dataset.colorId;
                refreshSizeAvailability();
            } else {
                paintStock('Aucune couleur disponible', 'out');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const groups = document.querySelectorAll('.summary-group');

            groups.forEach((group) => {
                const toggle = group.querySelector('.summary-toggle');
                const content = group.querySelector('.summary-content');
                const icon = group.querySelector('.summary-icon');

                if (!toggle || !content || !icon) return;

                toggle.addEventListener('click', () => {
                    const isOpen = group.dataset.open === 'true';
                    group.dataset.open = isOpen ? 'false' : 'true';
                    content.classList.toggle('hidden', isOpen);
                    icon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                });
            });
        });
    </script>
@endsection
