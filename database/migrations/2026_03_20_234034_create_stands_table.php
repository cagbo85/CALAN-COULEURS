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
        Schema::create('stands', function (Blueprint $table) {
            $table->comment('Stands et exposants du festival');
            $table->integer('id', true);
            $table->string('name')->comment('Nom du stand ou de la boutique');
            $table->text('description')->nullable()->comment('Description courte');
            $table->string('photo')->nullable()->comment('Chemin vers l\'image');
            $table->enum('type', ['boutique', 'foodtruck', 'tatouage', 'autre'])->comment('Catégorie du stand');
            $table->string('instagram_url')->nullable()->comment('Lien Instagram');
            $table->string('facebook_url')->nullable()->comment('Lien Facebook');
            $table->string('website_url')->nullable()->comment('Site web officiel');
            $table->string('other_link')->nullable()->comment('Autre lien (TikTok, etc.)');
            $table->integer('ordre')->default(0)->comment('Ordre d\'affichage');
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
        Schema::dropIfExists('stands');
    }
};
