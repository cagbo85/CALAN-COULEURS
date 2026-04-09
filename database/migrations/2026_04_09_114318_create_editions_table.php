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
        Schema::create('editions', function (Blueprint $table) {
            $table->comment('Éditions du festival');
            $table->integer('id', true);
            $table->integer('year')->unique('year')->comment('Année de l\'édition');
            $table->string('name')->nullable()->comment('Nom de l\'édition');
            $table->string('reservation_url')->nullable()->comment('Lien vers la billetterie de l\'édition');
            $table->dateTime('begin_date')->comment('Date et heure exacte de l\'ouverture des portes de l\'édition');
            $table->dateTime('ending_date')->comment('Date et heure exacte de la fermeture des portes de l\'édition');
            $table->boolean('actif')->default(false)->comment('Édition actif/inactif');
            $table->enum('status', ['draft', 'upcoming', 'ongoing', 'past', 'archived'])->default('draft')->comment('État du festival');
            $table->integer('created_by')->nullable()->index('created_by')->comment('ID utilisateur créateur');
            $table->integer('updated_by')->nullable()->index('updated_by')->comment('ID de l\'utilisateur qui a modifié');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Date de création');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->comment('Date de modification');

            $table->unique(['year'], 'year_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editions');
    }
};
