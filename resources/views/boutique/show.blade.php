@extends('layouts.boutique')

@section('title', $product->title . ' - Boutique Calan\'Couleurs')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image du produit -->
            <div>
                <img id="product-image" src="{{ asset($product->image) }}" alt="{{ $product->title }}"
                    class="w-full rounded-lg shadow-md">
            </div>

            <!-- Détails du produit -->
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ $product->title }}</h1>
                <p class="text-2xl font-bold text-blue-600 mb-4">{{ $product->price }}€</p>

                @if ($product->description)
                    <p class="text-gray-700 mb-6">{{ $product->description }}</p>
                @endif

                @if ($product->detailed_description)
                    <div class="mb-6">
                        <h3 class="font-semibold mb-2">Description détaillée</h3>
                        <p class="text-gray-700">{{ $product->detailed_description }}</p>
                    </div>
                @endif

                <!-- Formulaire de sélection -->
                <form id="product-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="selected-variant-id" name="variant_id" value="">

                    <!-- Sélecteur de taille -->
                    @if ($product->variants->pluck('size')->filter()->unique()->count() > 0)
                        <div>
                            <label class="block font-semibold mb-2">Taille :</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->variants->pluck('size')->filter()->unique() as $size)
                                    <button type="button"
                                        class="size-btn px-4 py-2 border border-gray-300 rounded hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                        data-size="{{ $size }}">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Sélecteur de couleur -->
                    @if ($product->variants->pluck('color')->filter()->unique()->count() > 0)
                        <div>
                            <label class="block font-semibold mb-2">Couleur :</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->variants->pluck('color')->filter()->unique() as $color)
                                    <button type="button"
                                        class="color-btn px-4 py-2 border border-gray-300 rounded hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 capitalize"
                                        data-color="{{ $color }}">
                                        {{ ucfirst($color) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantité -->
                    <div>
                        <label for="quantity" class="block font-semibold mb-2">Quantité :</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="10"
                            class="w-20 px-3 py-2 border border-gray-300 rounded focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        <span id="stock-info" class="text-sm text-gray-600 ml-2"></span>
                    </div>

                    <!-- Bouton d'achat -->
                    <button type="button" id="add-to-cart-btn"
                        class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-lg disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Ajouter au panier
                    </button>
                </form>

                <!-- Informations sur les variantes (pour le JS) -->
                <script type="application/json" id="variants-data">
                    {!! json_encode($product->variants->map(function($variant) {
                        return [
                            'id' => $variant->id,
                            'size' => $variant->size,
                            'color' => $variant->color,
                            'quantity' => $variant->quantity,
                            'image' => $variant->image ?: null
                        ];
                    })) !!}
                </script>
            </div>
        </div>
    </div>

    <!-- JavaScript pour la gestion des variantes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variants = JSON.parse(document.getElementById('variants-data').textContent);
            const productImage = document.getElementById('product-image');
            const selectedVariantId = document.getElementById('selected-variant-id');
            const stockInfo = document.getElementById('stock-info');
            const quantityInput = document.getElementById('quantity');
            const addToCartBtn = document.getElementById('add-to-cart-btn');

            let selectedSize = null;
            let selectedColor = null;

            // Gestion des boutons de taille
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove(
                        'bg-blue-500', 'text-white'));
                    this.classList.add('bg-blue-500', 'text-white');
                    selectedSize = this.dataset.size;
                    updateVariant();
                });
            });

            // Gestion des boutons de couleur
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove(
                        'bg-blue-500', 'text-white'));
                    this.classList.add('bg-blue-500', 'text-white');
                    selectedColor = this.dataset.color;
                    updateVariant();
                });
            });

            function updateVariant() {
                const variant = variants.find(v =>
                    (!selectedSize || v.size === selectedSize) &&
                    (!selectedColor || v.color === selectedColor)
                );

                if (variant) {
                    selectedVariantId.value = variant.id;

                    if (variant.image) {
                        productImage.src = '{{ asset('') }}' + variant.image;
                    }

                    stockInfo.textContent = `Stock disponible: ${variant.quantity}`;
                    quantityInput.max = variant.quantity;

                    if (variant.quantity > 0) {
                        addToCartBtn.disabled = false;
                        addToCartBtn.textContent = 'Ajouter au panier';
                    } else {
                        addToCartBtn.disabled = true;
                        addToCartBtn.textContent = 'Rupture de stock';
                    }
                }
            }

            // Gestion du bouton "Ajouter au panier"
            addToCartBtn.addEventListener('click', function() {
                const formData = new FormData(document.getElementById('product-form'));

                if (variants.length > 0 && !selectedVariantId.value) {
                    alert('Veuillez sélectionner une taille et/ou une couleur');
                    return;
                }

                // Désactiver le bouton pendant la requête
                addToCartBtn.disabled = true;
                addToCartBtn.textContent = 'Ajout en cours...';

                // Envoyer la requête AJAX
                fetch('{{ route('boutique.add-to-cart') }}', {
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
                            alert('Produit ajouté au panier !');
                            // Optionnel : mettre à jour le compteur du panier dans la navbar
                        } else {
                            alert(data.error || 'Erreur lors de l\'ajout au panier');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de l\'ajout au panier');
                    })
                    .finally(() => {
                        // Réactiver le bouton
                        addToCartBtn.disabled = false;
                        addToCartBtn.textContent = 'Ajouter au panier';
                    });
            });
        });
    </script>
@endsection
