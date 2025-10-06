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
        Schema::create('products', function (Blueprint $table) {
            $table->comment('Produits du de la boutique en ligne');
            $table->integer('id', true);
            $table->string('title')->comment('Titre du produit');
            $table->string('slug')->comment('Slug URL du produit');
            $table->text('description')->nullable()->comment('Description détaillée du produit');
            $table->mediumText('detailed_description')->nullable()->comment('Description longue du produit');
            $table->decimal('price', 10)->comment('Prix du produit en euros');
            $table->integer('stock_quantity')->default(0)->comment('Quantité en stock');
            $table->boolean('is_featured')->default(false)->comment('Produit mis en avant sur la page d\'accueil');
            $table->string('image')->nullable()->comment('Chemin vers l\'image principale du produit');
            $table->enum('category', ['vetements', 'accessoires', 'goodies'])->comment('Catégorie du produit');
            $table->boolean('actif')->default(true)->comment('Produit actif ou non');
            $table->integer('created_by')->nullable()->index('created_by')->comment('ID utilisateur créateur');
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
        Schema::dropIfExists('products');
    }
};
