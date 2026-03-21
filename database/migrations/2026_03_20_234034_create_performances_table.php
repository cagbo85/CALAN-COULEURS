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
        Schema::create('performances', function (Blueprint $table) {
            $table->comment('Table des performances des artistes du festival');
            $table->integer('id', true);
            $table->integer('edition_id')->index('performances_ibfk_1')->comment('ID de l\'édition du festival');
            $table->integer('artiste_id')->index('performances_ibfk_2')->comment('ID de l\'artiste');
            $table->dateTime('begin_date')->nullable()->comment('Date et heure exacte du début de la performance');
            $table->dateTime('ending_date')->nullable()->comment('Date et heure exacte de la fin de la performance');
            $table->enum('scene', ['Extérieur', 'Intérieur'])->nullable()->comment('Type de scène');
            $table->enum('day', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'])->nullable()->comment('Jour de passage');
            $table->boolean('actif')->default(true)->comment('Performance active/masquée');
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
        Schema::dropIfExists('performances');
    }
};
