<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductsVariant;
use Illuminate\Support\Facades\DB;
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
            return redirect()->route('boutique.cart')->with('error', 'Votre panier est vide');
        }

        // Validation du formulaire
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:100'
        ]);

        // Calculer le total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        // Stocker les données de commande en session pour HelloAsso
        session()->put('order_data', [
            'cart' => $cart,
            'customer' => $validated,
            'total' => $total,
            'order_id' => 'ORDER_' . Str::upper(Str::random(10)) // ID temporaire
        ]);

        // Redirection vers HelloAsso (on implémentera ça après)
        // Pour l'instant, on simule juste
        return view('boutique.helloasso-redirect', [
            'cart' => $cart,
            'customer' => $validated,
            'total' => $total
        ]);
    }

    public function orderSuccess(Request $request)
    {
        $orderData = session()->get('order_data');

        if (!$orderData) {
            return redirect()->route('boutique.index')->with('error', 'Aucune commande trouvée');
        }

        DB::beginTransaction();
        try {
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
                'helloasso_id' => $request->get('payment_id', 'TEST_' . Str::random(10)), // ID HelloAsso
                'status' => 'paid'
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

                // Décrémenter le stock
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

            DB::commit();

            // Vider le panier et les données de commande
            session()->forget(['cart', 'order_data']);

            // TODO: Envoyer email de confirmation

            return view('boutique.order-success', ['order' => $order]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('boutique.cart')->with('error', 'Erreur lors du traitement de la commande');
        }
    }

    public function orderCancel()
    {
        // Nettoyer les données de session si nécessaire
        return view('boutique.order-cancel');
    }
}
