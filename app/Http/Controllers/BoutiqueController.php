<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotificationMail;
use App\Mail\ContactMail;
use App\Mail\OrderRecapMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductsVariant;
use App\Models\Shipment;
use App\Services\HelloAssoService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BoutiqueController extends Controller
{
    public function index(Request $request)
    {
        $collections = [
            [
                'badge' => 't-shirt',
                'title' => 'Collection T-shirts',
                'description' => 'Designs exclusifs aux couleurs du festival',
                'image' => 'img/boutique/products/tshirt-classique_blanc_5.jpg',
            ],
            [
                'badge' => 'pull',
                'title' => 'Collection Pulls',
                'description' => 'Chaud, doux et coloré pour toutes les saisons',
                'image' => 'img/boutique/pull-demi-zip_vert.jpg',
            ],
            [
                'badge' => 'accessoire',
                'title' => 'Collection Accessoires',
                'description' => 'Lunettes, tote bags, gourdes et bandanas pour compléter ton style',
                'image' => 'img/boutique/lunettes-calan_bleu.jpg',
            ],
        ];

        return view('boutique.index', compact('collections'));
    }

    /**
     * Récupère toutes les couleurs disponibles.
     */
    public function getAllColors()
    {
        return DB::table('colors as c')
            ->select('c.id', 'c.name', 'c.hex_code as code')
            ->orderBy('c.ordre')
            ->get();
    }

    /**
     * Récupère toutes les tailles disponibles.
     */
    public function getAllSizes()
    {
        return DB::table('sizes')
            ->select('id', 'label')
            ->orderBy('ordre')
            ->get();
    }

    /**
     * Récupère toutes les variantes pour un produit donné.
     */
    public function getAllVariantsForProduct($productId)
    {
        return DB::table('products_variants as pv')
            ->select(
                'pv.id',
                'pv.product_id',
                'pv.size_id',
                'pv.color_id',
                'pv.quantity',
                'pv.image'
            )
            ->where('pv.product_id', $productId)
            ->get();
    }

    /**
     * Récupère les produits filtrés en fonction des critères donnés.
     */
    public function getFilteredProducts(Request $request)
    {
        $query = Product::where('actif', true);

        // Filtres dynamiques
        if ($request->filled('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }
        if ($request->filled('color')) {
            $colorIds = (array) $request->color;
            $query->whereHas('productsVariants', function ($q) use ($colorIds) {
                $q->whereIn('color_id', $colorIds);
            });
        }
        if ($request->filled('size')) {
            $sizeIds = (array) $request->size;
            $query->whereHas('productsVariants', function ($q) use ($sizeIds) {
                $q->whereIn('size_id', $sizeIds);
            });
        }
        if ($request->filled('stock')) {
            if ($request->stock == 'in') {
                $query->whereHas('productsVariants', function ($q) {
                    $q->where('quantity', '>', 0);
                });
            } elseif ($request->stock == 'out') {
                $query->whereHas('productsVariants', function ($q) {
                    $q->where('quantity', '=', 0);
                });
            }
        }
        if ($request->filled('category')) {
            $categories = (array) $request->category;
            $query->whereIn('category', $categories);
        }
        if ($request->filled('badge')) {
            if ($request->badge === 'nouveaute') {
                $query->where('is_featured', true);
            } else {
                $query->where('badge', $request->badge);
            }
        }

        return $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Récupère les variantes uniques par couleur pour tous les produits.
     */
    public function getUniqueVariantsForAllProducts()
    {
        return DB::table('products_variants as pv')
            ->join(
                DB::raw('(SELECT product_id, color_id, MIN(id) as min_id FROM products_variants GROUP BY product_id, color_id) as grouped'),
                function ($join) {
                    $join->on('pv.product_id', '=', 'grouped.product_id')
                        ->on('pv.color_id', '=', 'grouped.color_id')
                        ->on('pv.id', '=', 'grouped.min_id');
                }
            )
            ->leftJoin('colors as c', 'pv.color_id', '=', 'c.id')
            ->select(
                'pv.product_id',
                'pv.color_id',
                'pv.size_id',
                'pv.image',
                'c.name as color_name',
                'c.hex_code'
            )
            ->get()
            ->groupBy('product_id');
    }

    /**
     * Récupère les variantes uniques par couleur pour un produit donné.
     */
    public function getUniqueVariantsForOneProduct($productId)
    {
        return DB::table('products_variants as pv')
            ->join(
                DB::raw('(SELECT color_id, MIN(id) as min_id FROM products_variants WHERE product_id = '.$productId.' GROUP BY color_id) as grouped'),
                function ($join) {
                    $join->on('pv.color_id', '=', 'grouped.color_id')
                        ->on('pv.id', '=', 'grouped.min_id');
                }
            )
            ->leftJoin('colors as c', 'pv.color_id', '=', 'c.id')
            ->where('pv.product_id', $productId)
            ->select(
                'pv.id',
                'pv.product_id',
                'pv.color_id',
                'pv.size_id',
                'pv.image',
                'c.name as color_name',
                'c.hex_code'
            )
            ->get();
    }

    /**
     * Récupère les tailles uniques pour un produit donné.
     */
    public function getUniqueSizesForOneProduct($productId)
    {
        return DB::table('products_variants as pv')
            ->join('sizes as s', 'pv.size_id', '=', 's.id')
            ->where('pv.product_id', $productId)
            ->select('s.id', 's.label', 's.ordre')
            ->distinct()
            ->orderBy('s.ordre')
            ->get();
    }

    /**
     * Récupère le texte de stock pour une variante donnée.
     */
    public function getStockTextForVariant($variantId)
    {
        return DB::table('products_variants as pv')
            ->select(
                'pv.id',
                'pv.product_id',
                'pv.color_id',
                'pv.size_id',
                'pv.quantity',
                DB::raw("CASE
                WHEN pv.quantity = 0 THEN 'Rupture de stock'
                WHEN pv.quantity <= 3 THEN CONCAT('Plus que ', pv.quantity, ' en stock !')
                WHEN pv.quantity <= 10 THEN CONCAT(pv.quantity, ' articles en stock')
                ELSE 'En stock'
            END as stock_text")
            )
            ->where('id', $variantId)
            ->first();
    }

    /**
     * Récupère le texte de stock pour toutes les variantes d'un produit donné.
     */
    public function getStockTextsForProduct($productId)
    {
        return DB::table('products_variants')
            ->select(
                'id',
                'product_id',
                'color_id',
                'size_id',
                'quantity',
                DB::raw("CASE
                WHEN quantity = 0 THEN 'Rupture de stock'
                WHEN quantity <= 3 THEN CONCAT('Plus que ', quantity, ' en stock !')
                WHEN quantity <= 10 THEN CONCAT(quantity, ' articles en stock')
                ELSE 'En stock'
            END as stock_text")
            )
            ->where('product_id', $productId)
            ->get();
    }

    /**
     * Récupèrer toutes les images liées à un produit.
     */
    public function getImagesForProduct(int $productId)
    {
        return DB::table('products_images as pi')
            ->where('pi.product_id', $productId)
            ->orderBy('pi.ordre', 'asc')
            ->get();
    }

    /**
     * Affiche la liste des produits avec filtres.
     */
    public function products(Request $request)
    {
        // Liste complète des catégories et badges
        $categories = collect(['vetements', 'goodies', 'accessoires']);
        $badges = collect(['t-shirt', 'pull', 'accessoire']);

        // Récupère les produits filtrés
        $products = $this->getFilteredProducts($request);

        // Récupère les variants uniques par couleur
        $uniqueVariants = $this->getUniqueVariantsForAllProducts();

        $colors = $this->getAllColors();
        $sizes = $this->getAllSizes();

        return view('boutique.products', compact('products', 'sizes', 'colors', 'categories', 'badges', 'uniqueVariants'));
    }

    /**
     * Affiche la page de détail d'un produit.
     */
    public function show(Product $product)
    {
        if (! $product->actif) {
            abort(404);
        }

        $uniqueVariants = $this->getUniqueVariantsForOneProduct($product->id);

        $uniqueSizes = $this->getUniqueSizesForOneProduct($product->id);

        $allVariants = $this->getAllVariantsForProduct($product->id);

        $stockTexts = $this->getStockTextsForProduct($product->id)->keyBy('id');

        $productImages = $this->getImagesForProduct($product->id);

        $carouselImages = $productImages
            ->pluck('image')
            ->filter()
            ->values();

        if ($carouselImages->isEmpty() && ! empty($product->image)) {
            $carouselImages = collect([$product->image]);
        }

        return view('boutique.show', compact('product', 'uniqueVariants', 'uniqueSizes', 'stockTexts', 'allVariants', 'productImages', 'carouselImages'));
    }

    /**
     * Ajoute un produit au panier.
     */
    /**
     * Ajoute un produit au panier.
     */
    public function addToCart(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:products_variants,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        if ($validator->fails()) {
            // Construire un message d'erreur lisible
            $messages = collect($validator->errors()->messages())
                ->map(function ($msgs, $field) {
                    $names = [
                        'product_id' => 'Produit',
                        'variant_id' => 'Variante',
                        'quantity' => 'Quantité',
                    ];
                    $label = $names[$field] ?? $field;

                    return collect($msgs)->map(fn ($m) => "$label : $m");
                })
                ->flatten()
                ->implode(' | ');

            notify()->error("Erreurs de validation détectées : {$messages}", 'Validation échouée');

            return response()->json([
                'success' => false,
                'error' => 'Erreur de validation',
            ], 400);
        }

        // Récupération du produit et de la variante
        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id
            ? ProductsVariant::with(['size', 'color'])->findOrFail($request->variant_id)
            : null;

        // Vérification du stock
        $availableStock = $variant ? $variant->quantity : $product->stock_quantity;

        if ($request->quantity > $availableStock) {
            return response()->json(['error' => 'Stock insuffisant'], 400);
        }

        // Récupérer le panier actuel
        $cart = session()->get('cart', []);

        // Clé unique du panier
        $cartKey = $variant ? $variant->sku : "product_{$product->id}";

        // Si l'article existe déjà → incrémenter
        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $request->quantity;

            if ($newQuantity > $availableStock) {
                return response()->json(['error' => 'Stock insuffisant'], 400);
            }

            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            // Ajouter un nouvel article
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'sku' => $variant?->sku,
                'title' => $product->title,
                'size' => $variant?->size?->label,
                'color' => $variant?->color?->name,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'image' => $variant?->image ?? $product->image,
            ];
        }

        // Sauvegarder le panier
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Affiche le contenu du panier.
     */
    public function showCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = 0;

        // Nettoyer le panier des produits ou variantes supprimés
        foreach ($cart as $key => $item) {
            // Vérifier que le produit existe encore
            $product = Product::find($item['product_id']);
            if (! $product) {
                unset($cart[$key]);

                continue;
            }

            // Vérifier que la variante existe encore (si applicable)
            if (! empty($item['variant_id'])) {
                $variant = ProductsVariant::find($item['variant_id']);
                if (! $variant) {
                    unset($cart[$key]);

                    continue;
                }
            }

            // Calcul du total
            $total += $item['quantity'] * $item['unit_price'];
        }

        // Mettre à jour le panier nettoyé
        session()->put('cart', $cart);

        // Récupérer les variantes disponibles pour chaque produit du panier
        $productIds = collect($cart)
            ->pluck('product_id')
            ->unique()
            ->values();

        $variantsByProduct = ProductsVariant::with(['size', 'color'])
            ->whereIn('product_id', $productIds)
            ->where('quantity', '>', 0)
            ->orderBy('id')
            ->get()
            ->groupBy('product_id');

        // Si AJAX → renvoyer juste le panel
        if ($request->ajax() || $request->get('ajax')) {
            return view('boutique.partials.cart-panel-content', compact('cart', 'total'))->render();
        }

        // Sinon → page complète
        return view('boutique.cart', compact('cart', 'total', 'variantsByProduct'));
    }

    /**
     * Met à jour la quantité d'un article dans le panier ou le supprime si la quantité est à 0.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_key' => 'required',
            'quantity' => 'required|integer|min:0|max:10',
            'variant_id' => 'nullable|exists:products_variants,id',
        ]);

        $cart = session()->get('cart', []);
        $cartKey = $request->cart_key;
        $newQty = (int) $request->quantity;

        // Vérifier que l'article existe dans le panier
        if (! isset($cart[$cartKey])) {
            notify()->error("L'article que vous essayez de modifier n'existe pas dans le panier.", 'Article introuvable');

            return redirect()->route('boutique.cart');
        }

        $item = $cart[$cartKey];

        // Si quantité = 0 → suppression
        if ($newQty === 0) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            notify()->success('Article supprimé du panier.', 'Succès');

            return redirect()->route('boutique.cart');
        }

        // Vérification du stock
        if (! empty($item['variant_id'])) {
            // Variante
            $variant = ProductsVariant::find($item['variant_id']);
            if (! $variant) {
                notify()->error('Variante introuvable.', 'Erreur');

                return redirect()->route('boutique.cart');
            }

            if ($newQty > (int) $variant->quantity) {
                notify()->error('Stock insuffisant pour cette quantité.', 'Erreur');

                return redirect()->route('boutique.cart');
            }
        } else {
            // Produit simple
            $product = Product::find($item['product_id']);
            if (! $product) {
                notify()->error('Produit introuvable.', 'Erreur');

                return redirect()->route('boutique.cart');
            }

            if ($newQty > (int) $product->stock_quantity) {
                notify()->error('Stock insuffisant pour cette quantité.', 'Erreur');

                return redirect()->route('boutique.cart');
            }
        }

        // Mise à jour de la quantité
        $cart[$cartKey]['quantity'] = $newQty;
        session()->put('cart', $cart);

        notify()->success('Quantité mise à jour avec succès.', 'Succès');

        return redirect()->route('boutique.cart');
    }

    /**
     * Vide le panier.
     */
    public function clearCart()
    {
        session()->forget('cart');

        notify()->success(
            'Panier vidé avec succès.',
            'Succès'
        );

        return redirect()->route('boutique.cart');
    }

    /**
     * Affiche la page de checkout.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            notify()->error('Votre panier est vide', 'Erreur');

            return redirect()->route('boutique.cart');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        return view('boutique.checkout', compact('cart', 'total'));
    }

    /**
     * Traite le checkout et crée la commande.
     */
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            notify()->error('Votre panier est vide', 'Erreur');

            return redirect()->route('boutique.cart');
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            notify()->error('Erreurs de validation détectées.', 'Validation échouée');

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Calcul du total
        $total = array_reduce(
            $cart,
            fn ($sum, $item) => $sum + ($item['quantity'] * $item['unit_price']),
            0
        );

        DB::beginTransaction();
        try {
            // 1) Créer la commande PENDING
            $orderToken = (string) Str::uuid();

            $order = Order::create([
                'email' => $validated['email'],
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'adresse' => $validated['adresse'],
                'ville' => $validated['ville'],
                'code_postal' => $validated['code_postal'],
                'pays' => $validated['pays'],
                'total_amount' => $total,
                'helloasso_id' => null,
                'payment_status' => null,
                'cashout_state' => null,
                'helloasso_payment_id' => null,
                'paid_at' => null,
                'payment_metadata' => null,
                'token' => $orderToken,
                'stock_decremented' => false,
                'status' => 'pending',
            ]);

            // 2) Créer les order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }

            // 3) Construire la requête HelloAsso
            $helloAssoService = app(HelloAssoService::class);

            $checkoutData = $this->buildHelloAssoCheckoutData(
                $cart,
                $validated,
                $total,
                $orderToken,
                $order->id
            );

            // Forcer returnUrl avec token
            $checkoutData['returnUrl'] = url('/commande/success?order_token='.$orderToken, [], true);

            // Ajouter metadata essentiels
            $checkoutData['metadata']['order_token'] = $orderToken;
            $checkoutData['metadata']['order_id'] = $order->id;

            // Appel HelloAsso
            $checkoutResponse = $helloAssoService->createOrder($checkoutData);

            Log::debug('HelloAsso createOrder response', ['response' => $checkoutResponse]);

            // 4) Récupérer les IDs HelloAsso proprement
            $helloassoOrderId = data_get($checkoutResponse, 'order.id')
                ?? data_get($checkoutResponse, 'orderId')
                ?? data_get($checkoutResponse, 'data.order.id');

            $checkoutIntentId = data_get($checkoutResponse, 'id')
                ?? data_get($checkoutResponse, 'checkoutIntentId')
                ?? data_get($checkoutResponse, 'checkout_intent_id')
                ?? data_get($checkoutResponse, 'payment.id');

            // 5) Mettre à jour la commande
            $order->helloasso_id = $helloassoOrderId;
            $order->helloasso_payment_id = $checkoutIntentId;
            $order->save();

            // 6) Stocker minimalement en session
            session()->put('order_data', [
                'order_id' => $order->id,
                'order_token' => $orderToken,
                'cart' => $cart,
                'customer' => $validated,
                'total' => $total,
                'helloasso_order_id' => $helloassoOrderId,
                'checkout_intent_id' => $checkoutIntentId,
            ]);

            DB::commit();

            // 7) Redirection HelloAsso
            if (! data_get($checkoutResponse, 'redirectUrl')) {
                Log::error('HelloAsso createOrder missing redirectUrl', ['response' => $checkoutResponse]);
                notify()->error('Impossible de démarrer le paiement.', 'Erreur');

                return redirect()->route('boutique.checkout');
            }

            return redirect($checkoutResponse['redirectUrl']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur processCheckout HelloAsso', ['error' => $e->getMessage()]);
            notify()->error('Une erreur est survenue lors du traitement de votre commande.', 'Erreur');

            return redirect()->route('boutique.checkout')->withInput();
        }
    }

    private function sendOrderRecapIfNeeded(Order $order): void
    {
        $order->loadMissing([
            'orderItems.product',
            'orderItems.productsVariant.size',
            'orderItems.productsVariant.color',
        ]);

        if ($order->status !== 'paid') {
            return;
        }

        if (! empty($order->recap_sent_at)) {
            return;
        }

        if (empty($order->email)) {
            Log::warning('Recap commande non envoye: email client manquant', ['order_id' => $order->id]);

            return;
        }

        Mail::send(new OrderRecapMail($order));
        Mail::send(new AdminOrderNotificationMail($order));

        $order->forceFill([
            'recap_sent_at' => now(),
        ])->save();
    }

    /**
     * Construire les données pour HelloAsso Checkout
     */
    private function buildHelloAssoCheckoutData(array $cart, array $customer, float $total, string $orderToken, int $orderId): array
    {
        $items = [];

        foreach ($cart as $cartItem) {
            // Construire le nom de l'article proprement
            $options = array_filter([
                $cartItem['size'] ?? null,
                isset($cartItem['color']) ? ucfirst($cartItem['color']) : null,
            ]);

            $name = $cartItem['title'].(count($options) ? ' ('.implode(' - ', $options).')' : '');

            $items[] = [
                'name' => $name,
                'priceCategory' => 'Fixed',
                'price' => (int) ($cartItem['unit_price'] * 100), // en centimes
                'quantity' => $cartItem['quantity'],
            ];
        }

        return [
            'totalAmount' => (int) ($total * 100),
            'initialAmount' => (int) ($total * 100),
            'itemName' => 'Commande Boutique Calan\'Couleurs',
            'backUrl' => url('/panier', [], true),
            'errorUrl' => url('/commande/cancel', [], true),
            'returnUrl' => url('/commande/success?order_token='.$orderToken, [], true),
            'containsDonation' => false,
            'payer' => [
                'firstName' => $customer['firstname'],
                'lastName' => $customer['lastname'],
                'email' => $customer['email'],
                'address' => $customer['adresse'],
                'city' => $customer['ville'],
                'zipCode' => $customer['code_postal'],
                'country' => $customer['pays'],
            ],
            'items' => $items,
            'metadata' => [
                'order_type' => 'boutique',
                'order_token' => $orderToken,
                'order_id' => $orderId,
                'customer_address' => json_encode($customer),
            ],
        ];
    }

    /**
     * Affiche la page de commande réussie.
     */
    public function orderSuccess(Request $request)
    {
        // 1) Retrouver la commande : session -> token -> helloasso_id
        $order = null;
        $orderData = session()->get('order_data');

        if (! empty($orderData['order_id'])) {
            $order = Order::find($orderData['order_id']);
        }

        if (! $order) {
            $orderToken = $request->query('order_token') ?: ($orderData['order_token'] ?? null);
            if ($orderToken) {
                $order = Order::where('token', $orderToken)->first();
            }
        }

        if (! $order) {
            $helloassoId = $request->get('orderId') ?: ($orderData['helloasso_order_id'] ?? null);
            if ($helloassoId) {
                $order = Order::where('helloasso_id', $helloassoId)->first();
            }
        }

        if (! $order) {
            notify()->error('Aucune commande trouvée', 'Erreur');

            return redirect()->route('boutique.index');
        }

        // 2) Récupérer infos HelloAsso
        $helloAssoService = app(HelloAssoService::class);
        $helloAssoData = null;

        $helloassoId = $order->helloasso_id
            ?? ($orderData['helloasso_order_id'] ?? null)
            ?? $request->query('orderId')
            ?? null;

        $checkoutIntentId = $order->helloasso_payment_id
            ?? ($orderData['checkout_intent_id'] ?? null)
            ?? null;

        if ($helloassoId) {
            try {
                $helloAssoData = $helloAssoService->getOrder($helloassoId);
                Log::debug('HelloAsso getOrder response', ['data' => $helloAssoData]);
            } catch (\Exception $e) {
                Log::warning('Impossible de récupérer HelloAsso par order id', ['id' => $helloassoId, 'error' => $e->getMessage()]);
            }
        }

        if (! $helloAssoData && $checkoutIntentId) {
            try {
                if (method_exists($helloAssoService, 'getOrderByCheckoutIntent')) {
                    $helloAssoData = $helloAssoService->getOrderByCheckoutIntent($checkoutIntentId);
                    Log::debug('HelloAsso getOrderByCheckoutIntent response', ['data' => $helloAssoData]);
                }
            } catch (\Exception $e) {
                Log::warning('Impossible de récupérer HelloAsso par checkout intent', ['id' => $checkoutIntentId, 'error' => $e->getMessage()]);
            }
        }

        // 3) Extraire paymentStatus et cashOutState proprement
        $paymentStatus = strtolower(
            data_get($helloAssoData, 'payments.0.state')
                ?? data_get($helloAssoData, 'items.0.state')
                ?? data_get($helloAssoData, 'state')
                ?? null
        );

        $cashOutState = strtolower(
            data_get($helloAssoData, 'cashOutState')
                ?? data_get($helloAssoData, 'payments.0.cashOutState')
                ?? null
        );

        // États de paiement valides
        $paidStates = ['authorized', 'registered'];
        $isPaid = in_array($paymentStatus, $paidStates, true);

        // 4) Mise à jour de la commande
        DB::beginTransaction();
        try {
            // ID HelloAsso
            $remoteOrderId = data_get($helloAssoData, 'id')
                ?? data_get($helloAssoData, 'data.id')
                ?? data_get($helloAssoData, 'order.id')
                ?? data_get($helloAssoData, 'checkoutIntentId');

            if ($remoteOrderId && empty($order->helloasso_id)) {
                $order->helloasso_id = (string) $remoteOrderId;
            }

            // Mettre à jour les champs
            $order->payment_status = $paymentStatus ?? $order->payment_status;
            $order->cashout_state = $cashOutState ?? $order->cashout_state;

            $order->helloasso_payment_id =
                data_get($helloAssoData, 'payments.0.id')
                ?? $order->helloasso_payment_id
                ?? data_get($helloAssoData, 'id');

            // Si payé → marquer la commande comme payée
            if ($isPaid) {
                $order->status = 'paid';
                $order->paid_at = $order->paid_at ?? now();
            }

            $order->save();

            // Décrémenter le stock si pas déjà fait
            if ($isPaid && ! $order->stock_decremented) {
                foreach ($order->orderItems as $oi) {
                    if ($oi->variant_id) {
                        $variant = ProductsVariant::find($oi->variant_id);
                        if ($variant) {
                            $variant->decrement('quantity', $oi->quantity);
                        }
                    } else {
                        $product = Product::find($oi->product_id);
                        if ($product) {
                            $product->decrement('stock_quantity', $oi->quantity);
                        }
                    }
                }

                $order->stock_decremented = true;
                $order->save();
            }

            // Envoi du récap si pas encore envoyé
            $this->sendOrderRecapIfNeeded($order);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de la commande après HelloAsso', ['error' => $e->getMessage()]);
            notify()->error('Une erreur est survenue lors du traitement de la confirmation de paiement.', 'Erreur');

            return redirect()->route('boutique.cart');
        }

        // 5) Nettoyer la session
        session()->forget(['cart', 'order_data']);

        return view('boutique.order-success', [
            'order' => $order,
            'helloasso_data' => $helloAssoData,
        ]);
    }

    /**
     * Affiche la page de commande annulée.
     */
    public function orderCancel()
    {
        // Nettoyer les données de session si nécessaire
        return view('boutique.order-cancel');
    }

    /**
     * Endpoint webhook HelloAsso (server-to-server)
     */
    public function helloassoWebhook(Request $request)
    {
        Log::info('HelloAsso webhook reçu');

        $payload = $request->all();

        // 1) Récupération des identifiants possibles
        $helloassoOrderId = data_get($payload, 'order.id')
            ?? data_get($payload, 'orderId');

        $possibleCheckoutIds = array_filter([
            data_get($payload, 'id'),
            data_get($payload, 'checkoutIntentId'),
            data_get($payload, 'checkout_intent_id'),
            data_get($payload, 'payments.0.id'),
        ]);

        $metadataToken = data_get($payload, 'metadata.order_token');

        // Si aucun identifiant → impossible de traiter
        if (! $helloassoOrderId && empty($possibleCheckoutIds) && ! $metadataToken) {
            return response()->json(['ok' => false, 'message' => 'Missing identifiers'], 400);
        }

        // 2) Trouver la commande
        $order = null;

        // a) Par helloasso_id
        if ($helloassoOrderId) {
            $order = Order::where('helloasso_id', (string) $helloassoOrderId)->first();
        }

        // b) Par helloasso_payment_id
        if (! $order && ! empty($possibleCheckoutIds)) {
            foreach ($possibleCheckoutIds as $cid) {
                $order = Order::where('helloasso_payment_id', (string) $cid)->first();
                if ($order) {
                    break;
                }
            }
        }

        // c) Par metadata.order_token
        if (! $order && $metadataToken) {
            $order = Order::where('token', $metadataToken)->first();
        }

        // d) Par items.metadata.order_token
        if (! $order && ! empty($payload['items'])) {
            foreach ($payload['items'] as $it) {
                $token = data_get($it, 'metadata.order_token');
                if ($token) {
                    $order = Order::where('token', $token)->first();
                    if ($order) {
                        break;
                    }
                }
            }
        }

        if (! $order) {
            Log::warning('Webhook HelloAsso : commande introuvable', [
                'helloasso_id' => $helloassoOrderId,
                'possibleCheckoutIds' => $possibleCheckoutIds,
                'payload' => $payload,
            ]);

            return response()->json(['ok' => false, 'message' => 'Order not found'], 404);
        }

        // 3) Récupération des statuts HelloAsso
        $paymentState = strtolower(
            data_get($payload, 'state')
                ?? data_get($payload, 'payment.state')
                ?? data_get($payload, 'payments.0.state')
                ?? data_get($payload, 'items.0.state')
                ?? null
        );

        $cashOutState = strtolower(
            data_get($payload, 'cashOutState')
                ?? data_get($payload, 'payments.0.cashOutState')
                ?? null
        );

        // États métier
        $paidStates = ['authorized', 'registered'];
        $refundStates = ['refunded', 'refunding', 'contested'];
        $cashoutCompletedStates = ['cashedout', 'transfered'];

        $isPaid = in_array($paymentState, $paidStates, true);
        $isRefunded = in_array($paymentState, $refundStates, true);
        $isCashoutCompleted = in_array($cashOutState, $cashoutCompletedStates, true);

        $shouldSendRecap = false;

        // 4) Mise à jour de la commande
        DB::transaction(function () use (
            $order,
            $paymentState,
            $cashOutState,
            $isPaid,
            $isRefunded,
            $isCashoutCompleted,
            &$shouldSendRecap
        ) {
            // Mettre à jour les statuts
            if ($paymentState) {
                $order->payment_status = substr($paymentState, 0, 255);
            }

            if ($cashOutState) {
                $order->cashout_state = substr($cashOutState, 0, 255);
            }

            // Paiement reçu
            if ($isPaid) {
                $order->status = 'paid';
                $order->paid_at = $order->paid_at ?? now();
            }

            // Remboursement
            if ($isRefunded) {
                $order->status = 'refunded';
                $order->refunded_at = $order->refunded_at ?? now();
            }

            // Versement reçu
            if ($isCashoutCompleted) {
                $order->cashout_at = $order->cashout_at ?? now();
            }

            $order->save();

            // Décrément stock si payé et pas encore fait
            if ($isPaid && ! $order->stock_decremented) {
                foreach ($order->orderItems as $oi) {
                    $model = $oi->variant_id
                        ? ProductsVariant::find($oi->variant_id)
                        : Product::find($oi->product_id);

                    if ($model) {
                        $model->decrement(
                            $oi->variant_id ? 'quantity' : 'stock_quantity',
                            $oi->quantity
                        );
                    }
                }

                $order->stock_decremented = true;
                $order->save();
            }

            // Envoi du récap si pas encore envoyé
            $shouldSendRecap = $isPaid && empty($order->recap_sent_at);
        });

        // 5) Envoi du récap si nécessaire
        if ($shouldSendRecap) {
            $this->sendOrderRecapIfNeeded($order->fresh());
        }

        return response()->json(['ok' => true]);
    }

    public function showBoutiqueForm()
    {
        return view('boutique.contact');
    }

    public function submitFormBoutique(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Envoyer l'email
        Mail::send(new ContactMail($request->only('name', 'email', 'message')));

        return back()->with('success', 'Votre message a été envoyé !');
    }

    /**
     * Affichage du tableau de bord / liste des commandes pour l'admin.
     */
    public function OrdersIndex()
    {
        $orders = $this->getAllOrders();

        return view('admin.orders.index', compact('orders'));

        // Récupérer toutes les commandes, des plus récentes aux plus anciennes,
        // avec leurs articles pour éviter les requêtes SQL en boucle (Eager Loading)
        // $orders = Order::with(['orderItems.product'])
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(15); // Système de pagination pour éviter de surcharger la page

        // return view('admin.boutique.index', compact('orders'));
    }

    /**
     * Afficher la liste des commandes
     */
    public function getAllOrders()
    {
        return DB::table('orders as o')
            ->select(
                'o.id',
                DB::raw("CONCAT(o.firstname, ' ', UPPER(o.lastname)) as client"),
                'o.email',
                'o.total_amount',
                DB::raw(
                    "CASE
                        WHEN o.status LIKE 'pending' THEN 'En attente'
                        WHEN o.status LIKE 'paid' THEN 'Payée'
                        WHEN o.status LIKE 'shipped' THEN 'Expédiée'
                        WHEN o.status LIKE 'delivered' THEN 'Livrée'
                        WHEN o.status LIKE 'cancelled' THEN 'Annulée'
                        WHEN o.status LIKE 'refunded' THEN 'Remboursée'
                        ELSE 'Non définie'
                    END AS statusLabel"
                ),
                DB::raw(
                    "CASE
                        WHEN o.status LIKE 'pending' THEN 'fa-solid fa-hourglass-half'
                        WHEN o.status LIKE 'paid' THEN 'fa-solid fa-credit-card'
                        WHEN o.status LIKE 'shipped' THEN 'fa-solid fa-truck-fast'
                        WHEN o.status LIKE 'delivered' THEN 'fa-solid fa-truck-ramp-box'
                        WHEN o.status LIKE 'cancelled' THEN 'fa-solid fa-ban'
                        WHEN o.status LIKE 'refunded' THEN 'fa-solid fa-arrows-rotate'
                        ELSE 'fa-solid fa-circle-question'
                    END as statusIcon"
                ),
                DB::raw(
                    "CASE
                        WHEN o.status LIKE 'pending' THEN 'purple'
                        WHEN o.status LIKE 'paid' THEN 'green'
                        WHEN o.status LIKE 'shipped' THEN 'green'
                        WHEN o.status LIKE 'delivered' THEN 'green'
                        WHEN o.status LIKE 'cancelled' THEN 'red'
                        WHEN o.status LIKE 'refunded' THEN 'gray'
                        ELSE 'gray'
                    END as statusColor"
                ),
                DB::raw(
                    "CASE
                        WHEN o.payment_status LIKE 'authorized' THEN 'Paiement accepté'
                        WHEN o.payment_status LIKE 'registered' THEN 'Paiements hors ligne'
                        ELSE 'Non définie'
                    END AS payment_statusLabel"
                ),
                DB::raw(
                    "CASE
                        WHEN o.payment_status LIKE 'authorized' THEN 'fa-solid fa-credit-card'
                        WHEN o.payment_status LIKE 'registered' THEN 'fa-solid fa-money-bill'
                        ELSE 'fa-solid fa-circle-question'
                    END as payment_statusIcon"
                ),
                DB::raw(
                    "CASE
                        WHEN o.payment_status LIKE 'authorized' THEN 'green'
                        WHEN o.payment_status LIKE 'registered' THEN 'green'
                        ELSE 'gray'
                    END as payment_statusColor"
                ),
                DB::raw("DATE_FORMAT(o.created_at, '%d/%m/%Y %H:%i') AS formatted_create_date")
            )
            ->orderBy('o.created_at', 'desc')
            ->get();
    }

    /**
     * Afficher les détails d'une commande
     */
    public function OrdersShow(string $id)
    {
        $order = $this->getOrderDetails($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Récupérer les détails d'une commande
     */
    public function getOrderDetails(string $id)
    {
        return DB::table('orders as o')
            ->select(
                'o.*',
                DB::raw("CONCAT(o.firstname, ' ', UPPER(o.lastname)) as client"),
                DB::raw(
                    "CASE
                        WHEN o.status LIKE 'pending' THEN 'En attente'
                        WHEN o.status LIKE 'paid' THEN 'Payée'
                        WHEN o.status LIKE 'shipped' THEN 'Expédiée'
                        WHEN o.status LIKE 'delivered' THEN 'Livrée'
                        WHEN o.status LIKE 'cancelled' THEN 'Annulée'
                        WHEN o.status LIKE 'refunded' THEN 'Remboursée'
                        ELSE 'Non définie'
                    END AS statusLabel"
                ),
                DB::raw(
                    "CASE
                        WHEN o.status LIKE 'pending' THEN 'fa-solid fa-hourglass-half'
                        WHEN o.status LIKE 'paid' THEN 'fa-solid fa-credit-card'
                        WHEN o.status LIKE 'shipped' THEN 'fa-solid fa-truck-fast'
                        WHEN o.status LIKE 'delivered' THEN 'fa-solid fa-truck-ramp-box'
                        WHEN o.status LIKE 'cancelled' THEN 'fa-solid fa-ban'
                        WHEN o.status LIKE 'refunded' THEN 'fa-solid fa-arrows-rotate'
                        ELSE 'fa-solid fa-circle-question'
                    END as statusIcon"
                ),
                DB::raw(
                    "CASE
                        WHEN o.status LIKE 'pending' THEN 'purple'
                        WHEN o.status LIKE 'paid' THEN 'green'
                        WHEN o.status LIKE 'shipped' THEN 'green'
                        WHEN o.status LIKE 'delivered' THEN 'green'
                        WHEN o.status LIKE 'cancelled' THEN 'red'
                        WHEN o.status LIKE 'refunded' THEN 'gray'
                        ELSE 'gray'
                    END as statusColor"
                ),
                DB::raw(
                    "CASE
                        WHEN o.payment_status LIKE 'authorized' THEN 'Paiement accepté'
                        WHEN o.payment_status LIKE 'registered' THEN 'Paiements hors ligne'
                        ELSE 'Non définie'
                    END AS payment_statusLabel"
                ),
                DB::raw(
                    "CASE
                        WHEN o.payment_status LIKE 'authorized' THEN 'fa-solid fa-credit-card'
                        WHEN o.payment_status LIKE 'registered' THEN 'fa-solid fa-money-bill'
                        ELSE 'fa-solid fa-circle-question'
                    END as payment_statusIcon"
                ),
                DB::raw(
                    "CASE
                        WHEN o.payment_status LIKE 'authorized' THEN 'green'
                        WHEN o.payment_status LIKE 'registered' THEN 'green'
                        ELSE 'gray'
                    END as payment_statusColor"
                ),
                DB::raw("DATE_FORMAT(o.created_at, '%d/%m/%Y %H:%i') AS formatted_create_date"),
                DB::raw("DATE_FORMAT(o.updated_at, '%d/%m/%Y %H:%i') AS formatted_updated_at"),
                DB::raw("DATE_FORMAT(o.paid_at, '%d/%m/%Y %H:%i') AS formatted_paid_at"),
                'u.login as updated_by_login'
            )
            ->leftJoin('users as u', 'u.id', '=', 'o.updated_by')
            ->where('o.id', $id)
            ->first();
    }

    /**
     * Mettre à jour les informations d'une commande
     */
    public function OrdersUpdate(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled,refunded',
        ], [
            'status.in' => 'Le statut sélectionné n\'est pas valide.',
        ]);

        if ($validator->fails()) {
            notify()->error(
                'Un problème a été détecté dans le formulaire. Veuillez vérifier les champs marqués en rouge.',
                'Erreur de validation'
            );

            Log::warning('Erreur de validation lors de la mise à jour de la commande', [
                'errors' => $validator->errors(),
                'user_id' => $user->id,
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            DB::transaction(function () use ($order, $request, $user) {
                $order->update([
                    'status' => $request->status,
                    'updated_by' => $user->id,
                ]);
            });

            if ($order->status === 'shipped') {
                Shipment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'status' => 'shipped',
                        'shipped_at' => now(),
                        'updated_by' => $user->id,
                    ]
                );
            }

            if ($order->status === 'delivered') {
                Shipment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'status' => 'delivered',
                        'delivered_at' => now(),
                        'updated_by' => $user->id,
                    ]
                );
            }

            if ($order->status === 'returned') {
                Shipment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'status' => 'returned',
                        'updated_by' => $user->id,
                    ]
                );
            }

            notify()->success('La commande a été mise à jour avec succès.', 'Mise à jour réussie');

            Log::info("Commande #{$order->id} mise à jour", [
                'new_status' => $order->status,
                'updated_by' => $user->id,
            ]);

            return redirect()->route('admin.orders.show', $order->id);
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la modification d\'une commande', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur de base de données : {$e->getMessage()}",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur de base de données s\'est produite lors de la modification d\'une commande. L\'équipe technique a été notifiée.',
                    'Erreur de base de données'
                );
            }

            return back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur générale lors de la modification d\'une commande', [
                'message' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            if (config('app.debug')) {
                notify()->error(
                    "Erreur technique : {$e->getMessage()} (Ligne {$e->getLine()})",
                    'Erreur technique détaillée'
                );
            } else {
                notify()->error(
                    'Une erreur inattendue s\'est produite lors de la modification d\'une commande. L\'équipe technique a été notifiée.',
                    'Erreur technique'
                );
            }

            return back()->withInput();
        }
    }
}
