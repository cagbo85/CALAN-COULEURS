<?php

use App\Http\Controllers\BoutiqueController;
use Illuminate\Support\Facades\Route;

Route::get('/boutique', [BoutiqueController::class, 'index'])->name('boutique.index');
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
