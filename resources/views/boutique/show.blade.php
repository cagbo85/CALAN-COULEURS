@extends('layouts.boutique')

@section('title', $product->title . ' - Boutique Calan\'Couleurs')

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
                <a href="{{ route('boutique.products') }}" class="hover:text-[#8F1E98]">Tous les produits</a>
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="text-[#8F1E98] font-semibold">{{ $product->title }}</span>
            </li>
        </ol>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-4">
                @php
                    $firstVariant = $uniqueVariants->first();
                @endphp
                <img id="product-image"
                    src="{{ asset($firstVariant && $firstVariant->image ? $firstVariant->image : $product->image) }}"
                    alt="{{ $product->title }}" class="w-full rounded-lg shadow-lg">
            </div>

            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $product->title }}</h1>
                    @if ($product->description)
                        <p class="text-gray-600 text-lg mb-4">{{ $product->description }}</p>
                    @endif

                    <div class="flex items-center space-x-3 mb-6">
                        <span class="text-3xl font-bold text-[#FF0F63]">{{ number_format($product->price, 2) }}€</span>
                        @if ($product->old_price && $product->old_price > $product->price)
                            <span
                                class="text-xl text-gray-400 line-through">{{ number_format($product->old_price, 2) }}€</span>
                            <span class="px-2 py-1 text-sm font-bold bg-red-100 text-red-600 rounded">
                                -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                            </span>
                        @endif
                    </div>
                </div>

                <form id="product-form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="selected-variant-id" name="variant_id" value="">

                    @if ($uniqueVariants->count() > 0)
                        <div>
                            <label class="block font-semibold text-lg mb-3">Couleur :</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($uniqueVariants as $variant)
                                    <button type="button"
                                        class="color-btn flex items-center space-x-2 px-4 py-2 border-2 rounded-lg transition
                                            {{ $loop->first ? 'bg-[#8F1E98] text-white border-[#8F1E98]' : 'border-gray-300 hover:border-[#8F1E98]' }}"
                                        data-color="{{ $variant->color_id }}" data-img-url="{{ asset($variant->image) }}"
                                        onclick="changeColor(this)">
                                        <div class="w-4 h-4 rounded-full border bg-[{{ $variant->hex_code }}]">
                                        </div>
                                        <span class="capitalize font-medium">{{ ucfirst($variant->color_name) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($uniqueSizes->count() > 0)
                        <div>
                            <label class="block font-semibold text-lg mb-3">Taille :</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($uniqueSizes as $size)
                                    <button type="button"
                                        class="size-btn px-4 py-2 border-2 rounded-lg font-medium transition
                                            {{ $loop->first ? 'bg-[#8F1E98] text-white border-[#8F1E98]' : 'border-gray-300 hover:border-[#8F1E98]' }}"
                                        data-size="{{ $size->id }}">
                                        {{ $size->label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div id="stock-message" class="p-3 rounded-lg hidden">
                        <span id="stock-text" class="font-medium"></span>
                    </div>

                    <div>
                        <label for="quantity" class="block font-semibold text-lg mb-2">Quantité :</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="1"
                            class="w-20 px-3 py-2 border-2 border-gray-300 rounded-lg focus:border-[#8F1E98] focus:ring-2 focus:ring-[#8F1E98]/20">
                    </div>

                    <button type="button" id="add-to-cart-btn"
                        class="w-full bg-[#8F1E98] hover:bg-[#FF0F63] text-white font-bold py-4 px-6 rounded-lg text-lg transition duration-300 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Ajouter au panier
                    </button>
                </form>

                <!-- Description détaillée -->
                {{-- @if ($product->detailed_description)
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 leading-relaxed">{{ $product->detailed_description }}</p>
                    </div>
                @endif --}}

                <div class="mt-8 space-y-4">
                    <h3 class="font-semibold text-xl mb-4">Informations produit</h3>

                    <div class="faq-item border border-gray-200 rounded-lg">
                        <button type="button" onclick="toggleFaqItem(this)"
                            class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                            <span class="font-medium">Matière et composition</span>
                            <svg class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden p-4 pt-0 text-gray-600">
                            @if ($product->badge == 't-shirt')
                                <p>100% coton bio certifié GOTS. Tissu doux et respirant, idéal pour un port quotidien.</p>
                            @elseif($product->badge == 'pull')
                                <p>80% coton, 20% polyester recyclé. Maille douce et chaude, parfaite pour les saisons
                                    fraîches.</p>
                            @else
                                <p>Matériaux de qualité premium, sélectionnés pour leur durabilité et leur confort.</p>
                            @endif
                        </div>
                    </div>

                    <div class="faq-item border border-gray-200 rounded-lg">
                        <button type="button" onclick="toggleFaqItem(this)"
                            class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                            <span class="font-medium">Conseils d'entretien</span>
                            <svg class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden p-4 pt-0 text-gray-600">
                            <ul class="space-y-1">
                                <li>• Lavage en machine à 30°C maximum</li>
                                <li>• Séchage à l'air libre de préférence</li>
                                <li>• Repassage à température moyenne</li>
                                <li>• Ne pas utiliser d'eau de javel</li>
                            </ul>
                        </div>
                    </div>

                    <div class="faq-item border border-gray-200 rounded-lg">
                        <button type="button" onclick="toggleFaqItem(this)"
                            class="w-full flex justify-between items-center p-4 text-left hover:bg-gray-50 transition">
                            <span class="font-medium">À propos de la livraison</span>
                            <svg class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="faq-content hidden p-4 pt-0 text-gray-600">
                            <ul class="space-y-2">
                                <li><strong>Livraison standard :</strong> 3-5 jours ouvrés (gratuite dès 50€)</li>
                                <li><strong>Retrait festival :</strong> Disponible sur site (gratuit)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const variants = @json($allVariants);

        document.addEventListener('DOMContentLoaded', function() {
            const productImage = document.getElementById('product-image');
            const selectedVariantId = document.getElementById('selected-variant-id');
            const stockMessage = document.getElementById('stock-message');
            const stockText = document.getElementById('stock-text');
            const quantityInput = document.getElementById('quantity');
            const addToCartBtn = document.getElementById('add-to-cart-btn');

            let selectedSize = null;
            let selectedColor = null;

            // Initialisation automatique avec la première couleur et la première taille affichées
            const firstColorBtn = document.querySelector('.color-btn');
            const firstSizeBtn = document.querySelector('.size-btn');
            selectedColor = firstColorBtn ? firstColorBtn.dataset.color : null;
            selectedSize = firstSizeBtn ? firstSizeBtn.dataset.size : null;
            updateVariant();

            // Gestion des boutons de taille
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.size-btn').forEach(b => {
                        b.classList.remove('bg-[#8F1E98]', 'text-white',
                            'border-[#8F1E98]');
                        b.classList.add('border-gray-300');
                    });
                    this.classList.add('bg-[#8F1E98]', 'text-white', 'border-[#8F1E98]');
                    this.classList.remove('border-gray-300');
                    selectedSize = this.dataset.size;
                    updateVariant();
                });
            });

            // Gestion des boutons de couleur
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.color-btn').forEach(b => {
                        b.classList.remove('bg-[#8F1E98]', 'text-white',
                            'border-[#8F1E98]');
                        b.classList.add('border-gray-300');
                    });
                    this.classList.add('bg-[#8F1E98]', 'text-white', 'border-[#8F1E98]');
                    this.classList.remove('border-gray-300');
                    selectedColor = this.dataset.color;
                    updateVariant();
                });
            });

            function updateVariant() {
                const variant = variants.find(v =>
                    (!selectedSize || v.size_id == selectedSize) &&
                    (!selectedColor || v.color_id == selectedColor)
                );

                if (variant) {
                    selectedVariantId.value = variant.id;

                    // Mettre à jour l'image
                    if (variant.image) {
                        productImage.src = '{{ asset('') }}' + variant.image;
                    }

                    // Message de stock dynamique
                    stockMessage.classList.remove('hidden');
                    if (variant.quantity > 0) {
                        if (variant.quantity <= 3) {
                            stockMessage.className = 'p-3 rounded-lg bg-orange-100 border border-orange-200';
                            stockText.className = 'font-medium text-orange-700';
                            stockText.textContent = `Plus que ${variant.quantity} en stock !`;
                        } else if (variant.quantity <= 10) {
                            stockMessage.className = 'p-3 rounded-lg bg-yellow-100 border border-yellow-200';
                            stockText.className = 'font-medium text-yellow-700';
                            stockText.textContent = `${variant.quantity} articles en stock`;
                        } else {
                            stockMessage.className = 'p-3 rounded-lg bg-green-100 border border-green-200';
                            stockText.className = 'font-medium text-green-700';
                            stockText.textContent = 'En stock';
                        }

                        quantityInput.max = variant.quantity;
                        addToCartBtn.disabled = false;
                        addToCartBtn.textContent = 'Ajouter au panier';
                        addToCartBtn.className =
                            'w-full bg-[#8F1E98] hover:bg-[#FF0F63] text-white font-bold py-4 px-6 rounded-lg text-lg transition duration-300';
                    } else {
                        stockMessage.className = 'p-3 rounded-lg bg-red-100 border border-red-200';
                        stockText.className = 'font-medium text-red-700';
                        stockText.textContent = 'Rupture de stock';

                        quantityInput.max = 0;
                        addToCartBtn.disabled = true;
                        addToCartBtn.textContent = 'Non disponible';
                        addToCartBtn.className =
                            'w-full bg-gray-400 text-white font-bold py-4 px-6 rounded-lg text-lg cursor-not-allowed';
                    }
                } else {
                    stockMessage.classList.remove('hidden');
                    stockMessage.className = 'p-3 rounded-lg bg-red-100 border border-red-200';
                    stockText.className = 'font-medium text-red-700';
                    stockText.textContent = 'Rupture de stock';

                    quantityInput.max = 0;
                    addToCartBtn.disabled = true;
                    addToCartBtn.textContent = 'Non disponible';
                    addToCartBtn.className =
                        'w-full bg-gray-400 text-white font-bold py-4 px-6 rounded-lg text-lg cursor-not-allowed';
                }
            }

            addToCartBtn.addEventListener('click', function() {
                const formData = new FormData(document.getElementById('product-form'));

                if (variants.length > 0 && !selectedVariantId.value) {
                    alert('Veuillez sélectionner une taille et/ou une couleur');
                    return;
                }

                addToCartBtn.disabled = true;
                addToCartBtn.textContent = 'Ajout en cours...';

                fetch('{{ route('boutique.add-to-cart', [], true) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: formData.get('product_id'),
                            variant_id: formData.get('variant_id') || null,
                            quantity: parseInt(formData.get('quantity'))
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartCounter(data.cart_count);
                            openCartPanel();
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de l\'ajout au panier');
                    })
                    .finally(() => {
                        addToCartBtn.disabled = false;
                        addToCartBtn.textContent = 'Ajouter au panier';
                    });
            });
        });

        // Fonction pour la FAQ produit
        function toggleFaqItem(button) {
            const faqItem = button.closest('.faq-item');
            const content = faqItem.querySelector('.faq-content');
            const icon = button.querySelector('svg');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Fonction pour changer la couleur et l'image du produit
        function changeColor(swatch) {
            // Désélectionner toutes les pastilles couleur
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.classList.remove('bg-[#8F1E98]', 'text-white', 'border-[#8F1E98]');
                btn.classList.add('border-gray-300');
            });

            // Sélectionner la nouvelle pastille
            swatch.classList.add('bg-[#8F1E98]', 'text-white', 'border-[#8F1E98]');
            swatch.classList.remove('border-gray-300');

            // Mettre à jour l'image si data-img-url existe
            const imageUrl = swatch.dataset.imgUrl;
            const productImage = document.getElementById('product-image');
            if (productImage && imageUrl) {
                productImage.src = imageUrl;
                productImage.alt = productImage.alt.split(' - Couleur')[0] + ' - Couleur ' + swatch.dataset.color;
            }
        }
    </script>
@endsection
