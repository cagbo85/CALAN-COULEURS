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
        Schema::create('colors', function (Blueprint $table) {
            $table->comment('Couleurs disponibles pour les produits');
            $table->integer('id', true);
            $table->string('name', 100)->unique('name')->comment('Nom de la couleur (ex: Rouge, Bleu, Vert)');
            $table->string('hex_code', 7)->nullable()->comment('Code hexadécimal de la couleur (ex: #FF5733)');
            $table->integer('ordre')->default(0)->comment('Ordre d\'affichage');
            $table->integer('created_by')->nullable()->index('colors_ibfk_1')->comment('ID utilisateur créateur');
            $table->integer('updated_by')->nullable()->index('colors_ibfk_2')->comment('ID de l\'utilisateur qui a modifié');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Date de création');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->comment('Date de modification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
