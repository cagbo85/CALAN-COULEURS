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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class BoutiqueController extends Controller
{
    // public function index()
    // {
    //     $products = DB::table('products')
    //         ->where('actif', true)
    //         ->orderBy('is_featured', 'desc')
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('boutique.index', compact('products'));
    // }

    public function index(Request $request)
    {
        $query = Product::where('actif', true);

        // Filtre par catégorie
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('boutique.index', compact('products'));
    }

    public function show(Product $product)
    {
        if (!$product->actif) {
            abort(404);
        }

        $product->load(['variants' => function ($query) {
            $query->orderBy('size')->orderBy('color');
        }]);

        return view('boutique.show', compact('product'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:products_variants,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductsVariant::findOrFail($request->variant_id) : null;

        // Vérifier le stock
        $availableStock = $variant ? $variant->quantity : $product->stock_quantity;
        if ($request->quantity > $availableStock) {
            return response()->json(['error' => 'Stock insuffisant'], 400);
        }

        // Récupérer le panier actuel
        $cart = session()->get('cart', []);

        // Créer une clé unique pour l'article
        $cartKey = $product->id . '_' . ($variant ? $variant->id : 'no_variant');

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
                'title' => $product->title,
                'size' => $variant ? $variant->size : null,
                'color' => $variant ? $variant->color : null,
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

    public function showCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        return view('boutique.cart', compact('cart', 'total'));
    }

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

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('boutique.cart')->with('success', 'Panier vidé');
    }

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

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            notify()->error("Votre panier est vide", "Erreur");
            return redirect()->route('boutique.cart');
        }

        // Validation du formulaire
        // $validated = $request->validate([
        //     'email' => 'required|email|max:255',
        //     'firstname' => 'required|string|max:255',
        //     'lastname' => 'required|string|max:255',
        //     'adresse' => 'required|string|max:255',
        //     'ville' => 'required|string|max:100',
        //     'code_postal' => 'required|string|max:20',
        //     'pays' => 'required|string|max:100'
        // ]);

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|max:255',
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'ville' => 'required|string|max:100',
                'code_postal' => 'required|string|max:20',
                'pays' => 'required|string|max:100'
            ],
            [
                'email.required' => 'L\'adresse email est obligatoire.',
                'email.email' => 'L\'adresse email doit être valide.',
                'firstname.required' => 'Le prénom est obligatoire.',
                'lastname.required' => 'Le nom est obligatoire.',
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
                    'email' => 'Email',
                    'firstname' => 'Prénom',
                    'lastname' => 'Nom',
                    'adresse' => 'Adresse',
                    'ville' => 'Ville',
                    'code_postal' => 'Code Postal',
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

            Log::warning("Erreur de validation lors de la crétion de l'artiste", [
                'errors' => $validator->errors(),
            ]);

            return back()->withErrors($validator->errors())->withInput();
        }

        $validated = $validator->validated();

        // Calculer le total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        try {
            $helloAssoService = app(HelloAssoService::class);

            $checkoutData = $this->buildHelloAssoCheckoutData($cart, $validated, $total);

            $checkoutResponse = $helloAssoService->createOrder($checkoutData);

            session()->put('order_data', [
                'cart' => $cart,
                'customer' => $validated,
                'total' => $total,
                'helloasso_order_id' => $checkoutResponse['order']['id'] ?? null,
                'checkout_intent_id' => $checkoutResponse['id'] ?? null
            ]);

            // Rediriger vers HelloAsso
            return redirect($checkoutResponse['redirectUrl']);
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Erreur lors de la création de la commande HelloAsso", [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            notify()->error("Une erreur est survenue lors du traitement de votre commande. Veuillez réessayer plus tard.", "Erreur");
            return redirect()->route('boutique.checkout')->withInput();
        } catch (\Exception $e) {
            Log::error("Erreur inattendue lors de la création de la commande HelloAsso", [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            notify()->error("Une erreur inattendue est survenue. Veuillez réessayer plus tard.", "Erreur");
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

        $ngrokUrl = 'https://6061093d25d1.ngrok-free.app';

        return [
            'totalAmount' => (int)($total * 100), // Montant total en centimes
            'initialAmount' => (int)($total * 100),
            'itemName' => 'Commande Boutique Calan\'Couleurs',
            'backUrl' => $ngrokUrl . '/panier',
            'errorUrl' => $ngrokUrl . '/commande/cancel',
            'returnUrl' => $ngrokUrl . '/commande/success',
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

    public function orderSuccess(Request $request)
    {
        $orderData = session()->get('order_data');

        if (!$orderData) {
            return redirect()->route('boutique.index')->with('error', 'Aucune commande trouvée');
        }

        DB::beginTransaction();
        try {
            $helloAssoService = app(HelloAssoService::class);
            $helloAssoOrderId = $request->get('orderId') ?: $orderData['helloasso_order_id'];

            $paymentStatus = 'pending';
            $helloAssoData = null;

            if ($helloAssoOrderId) {
                try {
                    $helloAssoData = $helloAssoService->getOrder($helloAssoOrderId);
                    $paymentStatus = strtolower($helloAssoData['state'] ?? 'pending');
                } catch (\Illuminate\Database\QueryException $e) {
                    Log::error("Erreur lors de la récupération de la commande HelloAsso", [
                        'error' => $e->getMessage(),
                        'stack' => $e->getTraceAsString(),
                        'helloasso_order_id' => $helloAssoOrderId
                    ]);
                } catch (\Exception $e) {
                    Log::error("Erreur inattendue lors de la récupération de la commande HelloAsso", [
                        'error' => $e->getMessage(),
                        'stack' => $e->getTraceAsString(),
                        'helloasso_order_id' => $helloAssoOrderId
                    ]);
                }
            }

            // Créer la commande en BDD
            $order = Order::create([
                'email' => $orderData['customer']['email'],
                'firstname' => $orderData['customer']['firstname'],
                'lastname' => $orderData['customer']['lastname'],
                'adresse' => $orderData['customer']['adresse'],
                'ville' => $orderData['customer']['ville'],
                'code_postal' => $orderData['customer']['code_postal'],
                'pays' => $orderData['customer']['pays'],
                'total_amount' => $orderData['total'],
                'helloasso_id' => $helloAssoOrderId,
                'status' => $paymentStatus === 'authorized' ? 'paid' : 'pending'
            ]);

            // Créer les articles de commande
            foreach ($orderData['cart'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);

                // Décrémenter le stock seulement si payé
                if ($paymentStatus === 'authorized') {
                    if ($item['variant_id']) {
                        $variant = ProductsVariant::find($item['variant_id']);
                        if ($variant) {
                            $variant->decrement('quantity', $item['quantity']);
                        }
                    } else {
                        $product = Product::find($item['product_id']);
                        if ($product) {
                            $product->decrement('stock_quantity', $item['quantity']);
                        }
                    }
                }
            }

            DB::commit();

            // Vider le panier et les données de commande
            session()->forget(['cart', 'order_data']);

            // TODO: Envoyer email de confirmation si payé

            return view('boutique.order-success', [
                'order' => $order,
                'helloasso_data' => $helloAssoData
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création commande après HelloAsso', [
                'error' => $e->getMessage(),
                'order_data' => $orderData
            ]);
            return redirect()->route('boutique.cart')->with('error', 'Erreur lors du traitement de la commande');
        }
    }

    public function orderCancel()
    {
        // Nettoyer les données de session si nécessaire
        return view('boutique.order-cancel');
    }
}
