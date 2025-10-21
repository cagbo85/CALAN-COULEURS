<?php

use App\Services\HelloAssoService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoutiqueController;

Route::get('/boutique', [BoutiqueController::class, 'index'])->name('boutique.index');
Route::get('/boutique/produits', [BoutiqueController::class, 'products'])->name('boutique.products');
Route::get('/boutique/{product:slug}', [BoutiqueController::class, 'show'])->name('boutique.show');

// Routes du panier
Route::post('/boutique/add-to-cart', [BoutiqueController::class, 'addToCart'])->name('boutique.add-to-cart');
Route::get('/panier', [BoutiqueController::class, 'showCart'])->name('boutique.cart');
Route::patch('/panier/update', [BoutiqueController::class, 'updateCart'])->name('boutique.update-cart');
Route::delete('/panier/clear', [BoutiqueController::class, 'clearCart'])->name('boutique.clear-cart');

// Routes de commande
Route::get('/commande', [BoutiqueController::class, 'checkout'])->name('boutique.checkout');
Route::post('/commande/process', [BoutiqueController::class, 'processCheckout'])->name('boutique.process-checkout');
Route::get('/commande/success', [BoutiqueController::class, 'orderSuccess'])->name('boutique.order-success');
Route::get('/commande/cancel', [BoutiqueController::class, 'orderCancel'])->name('boutique.order-cancel');

// Test HelloAsso Service
Route::get('/test-helloasso', function (HelloAssoService $helloAsso) {
    return response()->json($helloAsso->testConnection());
});

// Webhook HelloAsso (public URL - configure via HelloAsso dashboard)
Route::post('/webhook/helloasso', [BoutiqueController::class, 'helloassoWebhook'])->name('helloasso.webhook');

Route::get('/test-helloasso-complete', function (HelloAssoService $helloAsso) {
    try {
        $results = [];

        // 1. Info organisation
        $org = $helloAsso->apiCall("organizations/Charlzouu-Asso");
        $results['organization'] = [
            'name' => $org['name'],
            'url' => $org['url'] ?? 'N/A',
            'description' => $org['description'] ?? 'N/A'
        ];

        // 2. Formulaires existants
        $forms = $helloAsso->apiCall("organizations/Charlzouu-Asso/forms");
        $results['forms'] = [
            'total' => count($forms['data'] ?? []),
            'types' => array_column($forms['data'] ?? [], 'formType')
        ];

        // 3. Commandes
        $orders = $helloAsso->apiCall("organizations/Charlzouu-Asso/orders");
        $results['orders'] = [
            'total' => count($orders['data'] ?? [])
        ];

        return response()->json([
            'success' => true,
            'message' => 'Tests HelloAsso complets réussis !',
            'data' => $results
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});
