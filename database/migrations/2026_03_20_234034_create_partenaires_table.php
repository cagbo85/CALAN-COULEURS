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
        Schema::create('partenaires', function (Blueprint $table) {
            $table->comment('Partenaires du festival');
            $table->integer('id', true);
            $table->string('name')->comment('Nom du partenaire');
            $table->text('description')->nullable()->comment('Description du partenaire');
            $table->string('logo')->nullable()->comment('Chemin vers l\'image');
            $table->string('photo')->nullable()->comment('Photo du partenaire');
            $table->string('site_url')->nullable()->comment('Lien vers le site du partenaire');
            $table->string('instagram_url')->nullable()->comment('Lien Instagram');
            $table->string('facebook_url')->nullable()->comment('Lien Facebook');
            $table->string('linkedin_url')->nullable()->comment('Lien LinkedIn');
            $table->string('autre_url')->nullable()->comment('Autre lien');
            $table->string('phone', 20)->nullable()->comment('Numéro de téléphone');
            $table->string('adresse')->nullable()->comment('Adresse complète (numéro et rue)');
            $table->string('ville', 100)->nullable()->comment('Ville');
            $table->string('departement', 100)->nullable()->comment('Département ou région');
            $table->string('code_postal', 20)->nullable()->comment('Code postal');
            $table->string('pays', 100)->nullable()->comment('Pays');
            $table->decimal('latitude', 10, 8)->nullable()->comment('Latitude');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Longitude');
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
        Schema::dropIfExists('partenaires');
    }
};
