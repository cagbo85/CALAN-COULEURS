<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->comment('Articles dans les commandes');
            $table->integer('id', true);
            $table->integer('order_id')->index('order_items_ibfk_1')->comment('ID de la commande');
            $table->integer('product_id')->index('order_items_ibfk_2')->comment('ID du produit');
            $table->integer('variant_id')->nullable()->index('order_items_ibfk_3')->comment('ID de la variante du produit (taille, couleur, etc.)');
            $table->integer('quantity')->default(1)->comment('Quantité commandée');
            $table->decimal('unit_price', 10)->comment('Prix unitaire au moment de la commande');
            $table->integer('updated_by')->nullable()->index('updated_by')->comment('ID de l\'utilisateur qui a modifié');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Date de création');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->comment('Date de modification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
