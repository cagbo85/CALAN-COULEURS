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
        Schema::create('products_variants', function (Blueprint $table) {
            $table->comment('Variantes des produits (taille, couleur, etc.)');
            $table->integer('id', true);
            $table->integer('product_id')->index('products_variants_ibfk_3')->comment('ID du produit parent');
            $table->enum('size', ['XS', 'S', 'M', 'L', 'XL', 'XXL'])->nullable()->comment('Taille du produit');
            $table->string('color', 100)->nullable()->comment('Couleur du produit');
            $table->integer('quantity')->default(0)->comment('Quantité en stock pour cette variante');
            $table->string('image')->nullable()->comment('Chemin vers l\'image spécifique à cette variante (ex: couleur)');
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
        Schema::dropIfExists('products_variants');
    }
};
