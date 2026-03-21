<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products_images', function (Blueprint $table) {
            $table->comment('Images supplémentaires pour les produits et variantes');
            $table->integer('id', true);
            $table->integer('product_id')->nullable()->index('products_images_ibfk_1')->comment('ID du produit parent');
            $table->integer('variant_id')->nullable()->index('products_images_ibfk_2')->comment('ID de la variante (optionnel)');
            $table->string('image')->comment('Chemin vers l\'image du produit ou de la variante');
            $table->integer('ordre')->default(0)->comment('Ordre d\'affichage des images');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Date de création');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->comment('Date de modification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_images');
    }
};
