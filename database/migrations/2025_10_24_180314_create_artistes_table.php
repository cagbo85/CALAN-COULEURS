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
        Schema::create('artistes', function (Blueprint $table) {
            $table->comment('Table des artistes du festival');
            $table->integer('id', true);
            $table->string('name')->comment('Nom de scène de l\'artiste');
            $table->string('style', 100)->nullable()->comment('Style de musique de l\'artiste');
            $table->mediumText('description')->nullable()->comment('Description/bio de l\'artiste');
            $table->string('photo')->nullable()->comment('Chemin vers l\'image');
            $table->enum('day', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'])->comment('Jour de passage');
            $table->dateTime('begin_date')->comment('Date et heure exacte du début de la représentation');
            $table->dateTime('ending_date')->comment('Date et heure exacte de la fin de la représentation');
            $table->enum('scene', ['Extérieur', 'Intérieur'])->comment('Type de scène');
            $table->string('soundcloud_url', 500)->nullable()->comment('Lien SoundCloud');
            $table->string('spotify_url', 500)->nullable()->comment('Lien Spotify');
            $table->string('youtube_url', 500)->nullable()->comment('Lien YouTube Music');
            $table->string('deezer_url', 500)->nullable()->comment('Lien Deezer');
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
        Schema::dropIfExists('artistes');
    }
};
