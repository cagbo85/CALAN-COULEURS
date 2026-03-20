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
        Schema::create('sizes', function (Blueprint $table) {
            $table->comment('Tailles disponibles pour les produits');
            $table->integer('id', true);
            $table->string('label', 10)->unique('label')->comment('Libellé de la taille (XS, S, M, L, XL, XXL)');
            $table->string('description')->nullable()->comment('Description optionnelle de la taille');
            $table->integer('ordre')->default(0)->comment('Ordre d\'affichage');
            $table->integer('created_by')->nullable()->index('sizes_ibfk_1')->comment('ID utilisateur créateur');
            $table->integer('updated_by')->nullable()->index('sizes_ibfk_2')->comment('ID de l\'utilisateur qui a modifié');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Date de création');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->comment('Date de modification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
