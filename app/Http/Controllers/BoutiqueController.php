<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductsVariant;
use App\Services\HelloAssoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BoutiqueController extends Controller
{
    public function index(Request $request)
    {
        $collections = [
            [
                'badge' => 't-shirt',
                'title' => 'Collection T-shirts',
                'description' => 'Designs exclusifs aux couleurs du festival',
                'image' => 'img/boutique/tshirt-decontracte_blanc.webp',
            ],
            [
                'badge' => 'pull',
                'title' => 'Collection Pulls',
                'description' => 'Chaud, doux et coloré pour toutes les saisons',
                'image' => 'img/boutique/pull-premium_vert.webp',
            ],
            [
                'badge' => 'accessoire',
                'title' => 'Collection Accessoires',
                'description' => 'Lunettes, casquettes et plus pour compléter ton style',
                'image' => 'img/boutique/lunettes-calan-couleurs_noir.webp',
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
            $query->where('badge', $request->badge);
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
                DB::raw('(SELECT color_id, MIN(id) as min_id FROM products_variants WHERE product_id = ' . $productId . ' GROUP BY color_id) as grouped'),
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
        if (!$product->actif) {
            abort(404);
        }

        $uniqueVariants = $this->getUniqueVariantsForOneProduct($product->id);

        $uniqueSizes = $this->getUniqueSizesForOneProduct($product->id);

        $allVariants = $this->getAllVariantsForProduct($product->id);

        // $stockTexts = $this->getStockTextsForProduct($product->id);

        $stockTexts = $this->getStockTextsForProduct($product->id)->keyBy('id');

        return view('boutique.show', compact('product', 'uniqueVariants', 'uniqueSizes', 'stockTexts', 'allVariants'));
    }

    /**
     * Ajoute un produit au panier.
     */
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:products_variants,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                $fieldNames = [
                    'product_id' => 'Produit',
                    'variant_id' => 'Variante',
                    'quantity' => 'Quantité'
                ];

                $fieldName = $fieldNames[$field] ?? $field;
                foreach ($messages as $message) {
                    $errorMessages[] = "$fieldName : $message";
                }
            }

            $errorSummary = implode(' | ', $errorMessages);
            notify()->error(
                "Erreurs de validation détectées : {$errorSummary}",
                'Validation échouée'
            );
            return response()->json([
                'success' => false,
                'error' => 'Erreur de validation'
            ], 400);
        }

        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductsVariant::with(['size', 'color'])->findOrFail($request->variant_id) : null;

        // Vérifier le stock
        $availableStock = $variant ? $variant->quantity : $product->stock_quantity;
        if ($request->quantity > $availableStock) {
            return response()->json(['error' => 'Stock insuffisant'], 400);
        }

        // Récupérer le panier actuel
        $cart = session()->get('cart', []);

        // Créer une clé unique pour l'article
        $cartKey = $variant ? $variant->sku : ($product->id . '_no_variant');

        // Si l'article existe déjà, augmenter la quantité
        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $request->quantity;
            if ($newQuantity > $availableStock) {
                return response()->json(['error' => 'Stock insuffisant'], 400);
            }
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            // Ajouter nouvel article
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'sku' => $variant ? $variant->sku : null,
                'title' => $product->title,
                'size' => $variant && $variant->size ? $variant->size->label : null,
                'color' => $variant && $variant->color ? $variant->color->name : null,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'image' => $variant && $variant->image ? $variant->image : $product->image
            ];
        }

        // Sauvegarder dans la session
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    /**
     * Affiche le contenu du panier.
     */
    public function showCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        // Si AJAX, retourne juste le contenu du panneau
        if ($request->ajax() || $request->get('ajax')) {
            return view('boutique.partials.cart-panel-content', compact('cart', 'total'))->render();
        }

        // Sinon, vue classique du panier
        return view('boutique.cart', compact('cart', 'total'));
    }

    /**
     * Met à jour les quantités dans le panier.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_key' => 'required',
            'quantity' => 'required|integer|min:0|max:10'
        ]);

        $cart = session()->get('cart', []);

        if ($request->quantity == 0) {
            // Supprimer l'article
            unset($cart[$request->cart_key]);
        } else {
            // Mettre à jour la quantité
            if (isset($cart[$request->cart_key])) {
                $cart[$request->cart_key]['quantity'] = $request->quantity;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('boutique.cart')->with('success', 'Panier mis à jour');
    }

    /**
     * Vide le panier.
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('boutique.cart')->with('success', 'Panier vidé');
    }

    /**
     * Affiche la page de checkout.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('boutique.cart')->with('error', 'Votre panier est vide');
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
            notify()->error("Votre panier est vide", "Erreur");
            return redirect()->route('boutique.cart');
        }

        $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'ville' => 'required|string|max:100',
                'code_postal' => 'required|string|max:20',
                'pays' => 'required|string|max:100'
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom de famille est obligatoire.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'ville.required' => 'La ville est obligatoire.',
            'code_postal.required' => 'Le code postal est obligatoire.',
            'pays.required' => 'Le pays est obligatoire.'
        ]
        );

        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                $fieldNames = [
                    'email' => 'Adresse e-mail',
                    'firstname' => 'Prénom',
                    'lastname' => 'Nom de famille',
                    'adresse' => 'Adresse',
                    'ville' => 'Ville',
                    'code_postal' => 'Code postal',
                    'pays' => 'Pays'
                ];
                $fieldName = $fieldNames[$field] ?? $field;
                foreach ($messages as $message) {
                    $errorMessages[] = "$fieldName : $message";
                }
            }
            $errorSummary = implode(' | ', $errorMessages);
            notify()->error(
                "Erreurs de validation détectées : {$errorSummary}",
                'Validation échouée'
            );

            return back()->withErrors($validator->errors())->withInput();
        }

        $validated = $validator->validated();

        // Calculer le total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        DB::beginTransaction();
        try {
            // 1) Créer la commande PENDING avant redirection (token unique)
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
                'status' => 'pending'
            ]);

            // 2) Créer les order items (stock non modifié tant que pas payé)
            foreach ($cart as $cartKey => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);
            }

            // 3) Construire la requête HelloAsso et forcer returnUrl avec token
            $helloAssoService = app(HelloAssoService::class);
            $checkoutData = $this->buildHelloAssoCheckoutData($cart, $validated, $total);

            // Forcer returnUrl avec token pour retrouver la commande même si session perdue
            $checkoutData['returnUrl'] = url('/commande/success?order_token=' . $orderToken, [], true);

            $checkoutData['metadata']['order_token'] = $orderToken;

            $checkoutResponse = $helloAssoService->createOrder($checkoutData);

            Log::debug('HelloAsso createOrder response', ['response' => $checkoutResponse]);

            $helloassoOrderId = $checkoutResponse['order']['id'] ?? $checkoutResponse['orderId'] ?? $checkoutResponse['data']['order']['id'] ?? $checkoutResponse['order_id'] ?? null;

            $checkoutIntentId = $checkoutResponse['id'] ?? $checkoutResponse['checkoutIntentId'] ?? $checkoutResponse['checkout_intent_id'] ?? $checkoutResponse['payment']['id'] ?? null;

            Log::debug('HelloAsso createOrder checkoutIntentId', ['checkoutIntentId' => $checkoutIntentId]);

            // 4) Mettre à jour l'order avec l'ID HelloAsso si présent
            $order->helloasso_id = $helloassoOrderId;
            $order->helloasso_payment_id = $checkoutIntentId;
            $order->save();

            // 5) Stocker minimalement en session pour le retour navigateur
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

            if (empty($checkoutResponse['redirectUrl'])) {
                Log::error('HelloAsso createOrder missing redirectUrl', ['response' => $checkoutResponse]);
                notify()->error("Impossible de démarrer le paiement (redirect manquant). Contactez l'administrateur.", "Erreur");
                return redirect()->route('boutique.checkout');
            }

            return redirect($checkoutResponse['redirectUrl']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur processCheckout HelloAsso', ['error' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
            notify()->error("Une erreur est survenue lors du traitement de votre commande. Veuillez réessayer plus tard.", "Erreur");
            return redirect()->route('boutique.checkout')->withInput();
        }
    }

    /**
     * Construire les données pour HelloAsso Checkout
     */
    private function buildHelloAssoCheckoutData(array $cart, array $customer, float $total): array
    {
        $items = [];

        foreach ($cart as $cartItem) {
            $name = $cartItem['title'];
            if ($cartItem['size'] || $cartItem['color']) {
                $name .= ' (';
                if ($cartItem['size']) $name .= $cartItem['size'];
                if ($cartItem['color']) $name .= ' - ' . ucfirst($cartItem['color']);
                $name .= ')';
            }

            $items[] = [
                'name' => $name,
                'priceCategory' => 'Fixed',
                'price' => (int)($cartItem['unit_price'] * 100), // Prix en centimes
                'quantity' => $cartItem['quantity']
            ];
        }

        return [
            'totalAmount' => (int)($total * 100), // Montant total en centimes
            'initialAmount' => (int)($total * 100),
            'itemName' => 'Commande Boutique Calan\'Couleurs',
            'backUrl' => url('/panier', [], true),
            'errorUrl' => url('/commande/cancel', [], true),
            'returnUrl' => url('/commande/success', [], true),
            'containsDonation' => false,
            'payer' => [
                'firstName' => $customer['firstname'],
                'lastName' => $customer['lastname'],
                'email' => $customer['email'],
                'address' => $customer['adresse'],
                'city' => $customer['ville'],
                'zipCode' => $customer['code_postal'],
                'country' => $customer['pays']
            ],
            'items' => $items,
            'metadata' => [
                'order_type' => 'boutique',
                'customer_address' => json_encode($customer)
            ]
        ];
    }

    /**
     * Affiche la page de commande réussie.
     */
    public function orderSuccess(Request $request)
    {
        // 1) Tenter de retrouver la commande : priorité session -> order_token GET -> helloasso id
        $order = null;
        $orderData = session()->get('order_data');

        if (!empty($orderData['order_id'])) {
            $order = Order::find($orderData['order_id']);
        }

        if (!$order) {
            $orderToken = $request->query('order_token') ?: ($orderData['order_token'] ?? null);
            if ($orderToken) {
                $order = Order::where('token', $orderToken)->first();
            }
        }

        if (!$order) {
            // fallback : essayer avec helloasso_order_id en param ou session
            $helloassoId = $request->get('orderId') ?: ($orderData['helloasso_order_id'] ?? null);
            if ($helloassoId) {
                $order = Order::where('helloasso_id', $helloassoId)->first();
            }
        }

        if (!$order) {
            notify()->error("Aucune commande trouvée", "Erreur");
            return redirect()->route('boutique.index');
        }

        // 2) Récupérer infos HelloAsso si on a un helloasso_id
        $helloAssoService = app(HelloAssoService::class);
        $helloAssoData = null;
        $paymentStatus = null;
        $cashOutState = null;

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
                Log::warning('Impossible de récupérer les données HelloAsso par order id', ['id' => $helloassoId, 'error' => $e->getMessage()]);
                $helloAssoData = null;
            }
        }

        // si pas trouvé et qu'on a un checkoutIntentId, tenter fallback via service
        if (!$helloAssoData && $checkoutIntentId) {
            try {
                if (method_exists($helloAssoService, 'getOrderByCheckoutIntent')) {
                    $helloAssoData = $helloAssoService->getOrderByCheckoutIntent($checkoutIntentId);
                    Log::debug('HelloAsso getOrderByCheckoutIntent response', ['data' => $helloAssoData]);
                } else {
                    Log::debug('HelloAssoService::getOrderByCheckoutIntent not available, skipping');
                }
            } catch (\Exception $e) {
                Log::warning('Impossible de récupérer HelloAsso par checkout intent', ['id' => $checkoutIntentId, 'error' => $e->getMessage()]);
            }
        }

        if ($helloAssoData) {
            // récupérer le statut de paiement (plusieurs emplacements possibles)
            if (!empty($helloAssoData['payments'][0]['state'])) {
                $paymentStatus = strtolower($helloAssoData['payments'][0]['state']);
            } elseif (!empty($helloAssoData['items'][0]['state'])) {
                $paymentStatus = strtolower($helloAssoData['items'][0]['state']);
            } elseif (!empty($helloAssoData['state'])) {
                $paymentStatus = strtolower($helloAssoData['state']);
            }

            $cashOutState = $helloAssoData['cashOutState'] ?? ($helloAssoData['payments'][0]['cashOutState'] ?? null);
            if ($cashOutState) $cashOutState = strtolower($cashOutState);
        }

        $paidStates = ['authorized', 'processed', 'registered'];
        $isPaid = $paymentStatus && in_array($paymentStatus, $paidStates, true);

        // 3) Mettre à jour la commande en base et décrémenter stock idempotent
        DB::beginTransaction();
        try {
            // --- NOUVEAU : extraire l'ID de commande HelloAsso depuis la réponse (plusieurs chemins possibles)
            $remoteOrderId = $helloAssoData['id']
                ?? ($helloAssoData['data']['id'] ?? null)
                ?? ($helloAssoData['order']['id'] ?? null)
                ?? ($helloAssoData['checkoutIntentId'] ?? null);

            // si on a trouvé un remoteOrderId et que l'order->helloasso_id est vide, on le sauve
            if ($remoteOrderId && empty($order->helloasso_id)) {
                $order->helloasso_id = (string)$remoteOrderId;
            }

            // sécuriser/tronquer avant sauvegarde
            $order->payment_status = $paymentStatus ?? $order->payment_status;
            $order->cashout_state = $cashOutState ?? $order->cashout_state;
            $order->helloasso_payment_id = $helloAssoData['payments'][0]['id'] ?? $order->helloasso_payment_id ?? ($helloAssoData['id'] ?? $order->helloasso_payment_id ?? null);

            if ($isPaid) {
                $order->status = 'paid';
                $order->paid_at = $order->paid_at ?? now();
            }

            $order->save();

            // Décrémenter le stock si payé et non encore fait (idempotence)
            if ($isPaid && !$order->stock_decremented) {
                foreach ($order->orderItems as $oi) {
                    if ($oi->variant_id) {
                        $variant = ProductsVariant::find($oi->variant_id);
                        if ($variant) $variant->decrement('quantity', $oi->quantity);
                    } else {
                        $product = Product::find($oi->product_id);
                        if ($product) $product->decrement('stock_quantity', $oi->quantity);
                    }
                }
                $order->stock_decremented = true;
                $order->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de la commande après HelloAsso', ['error' => $e->getMessage()]);
            notify()->error("Une erreur est survenue lors du traitement de la confirmation de paiement.", "Erreur");
            return redirect()->route('boutique.cart');
        }

        // 4) Nettoyer session (cart/order_data) — garder l'order en base
        session()->forget(['cart', 'order_data']);

        return view('boutique.order-success', [
            'order' => $order,
            'helloasso_data' => $helloAssoData
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

        // tenter de récupérer l'id de commande HelloAsso (id final) ou checkout/paiement id
        $helloassoOrderId = $payload['order']['id'] ?? $payload['orderId'] ?? null;
        $possibleCheckoutIds = [];
        if (!empty($payload['id'])) $possibleCheckoutIds[] = $payload['id'];
        if (!empty($payload['checkoutIntentId'])) $possibleCheckoutIds[] = $payload['checkoutIntentId'];
        if (!empty($payload['checkout_intent_id'])) $possibleCheckoutIds[] = $payload['checkout_intent_id'];
        if (!empty($payload['payments'][0]['id'])) $possibleCheckoutIds[] = $payload['payments'][0]['id'];

        $paymentState = null;
        if (!empty($payload['state'])) $paymentState = strtolower($payload['state']);
        elseif (!empty($payload['payment']['state'])) $paymentState = strtolower($payload['payment']['state']);
        elseif (!empty($payload['payments'][0]['state'])) $paymentState = strtolower($payload['payments'][0]['state']);
        elseif (!empty($payload['items'][0]['state'])) $paymentState = strtolower($payload['items'][0]['state']);

        $cashOutState = $payload['cashOutState'] ?? ($payload['payments'][0]['cashOutState'] ?? null);
        if ($cashOutState) $cashOutState = strtolower($cashOutState);

        // Si on n'a ni order id ni checkout id ni token, on ne peut pas rattacher la commande
        $hasAnyId = $helloassoOrderId || !empty($possibleCheckoutIds) || (!empty($payload['metadata']['order_token'] ?? null));
        if (!$hasAnyId) {
            return response()->json(['ok' => false, 'message' => 'Missing identifiers'], 400);
        }

        // Recherche principale par helloasso_id si fourni
        $order = null;
        if ($helloassoOrderId) {
            $order = Order::where('helloasso_id', (string)$helloassoOrderId)->first();
        }

        // fallback : chercher par helloasso_payment_id / checkout intent id
        if (!$order && !empty($possibleCheckoutIds)) {
            foreach ($possibleCheckoutIds as $cid) {
                $order = Order::where('helloasso_payment_id', (string)$cid)->first();
                if ($order) break;
            }
        }

        // fallback : chercher par metadata.order_token
        if (!$order && !empty($payload['metadata']['order_token'])) {
            $order = Order::where('token', $payload['metadata']['order_token'])->first();
        }

        // fallback : chercher par token dans items metadata (si présent)
        if (!$order && !empty($payload['items'])) {
            foreach ($payload['items'] as $it) {
                if (!empty($it['metadata']['order_token'])) {
                    $order = Order::where('token', $it['metadata']['order_token'])->first();
                    if ($order) break;
                }
            }
        }

        if (!$order) {
            Log::warning('Webhook HelloAsso : commande introuvable', ['helloasso_id' => $helloassoOrderId, 'possibleCheckoutIds' => $possibleCheckoutIds, 'payload' => $payload]);
            return response()->json(['ok' => false, 'message' => 'Order not found'], 404);
        }

        // Si order trouvé et helloasso_id vide mais payload contient l'id final, on le sauvegarde
        if (empty($order->helloasso_id) && $helloassoOrderId) {
            $order->helloasso_id = (string)$helloassoOrderId;
        }

        $paidStates = ['authorized', 'processed', 'registered'];
        $isPaid = $paymentState && in_array($paymentState, $paidStates, true);

        DB::transaction(function () use ($order, $paymentState, $cashOutState, $isPaid) {
            // tronquer valeurs externes pour sécurité
            $order->payment_status = $paymentState ? substr($paymentState, 0, 255) : $order->payment_status;
            $order->cashout_state = $cashOutState ? substr($cashOutState, 0, 255) : $order->cashout_state;
            if ($isPaid) {
                $order->status = 'paid';
                $order->paid_at = $order->paid_at ?? now();
            }
            $order->save();

            // décrémenter les stocks si payé et pas encore fait
            if ($isPaid && !$order->stock_decremented) {
                foreach ($order->orderItems as $oi) {
                    if ($oi->variant_id) {
                        $variant = ProductsVariant::find($oi->variant_id);
                        if ($variant) $variant->decrement('quantity', $oi->quantity);
                    } else {
                        $product = Product::find($oi->product_id);
                        if ($product) $product->decrement('stock_quantity', $oi->quantity);
                    }
                }
                $order->stock_decremented = true;
                $order->save();
            }
        });

        return response()->json(['ok' => true]);
    }
}
