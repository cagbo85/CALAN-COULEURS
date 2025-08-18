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
            $table->id();
            $table->string('name');
            $table->string('style')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->dateTime('begin_date');
            $table->dateTime('ending_date');
            $table->enum('scene', ['Intérieur', 'Extérieur'])->default('Extérieur');
            $table->boolean('actif')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Index pour les performances
            $table->index(['actif', 'begin_date']);
            $table->index('scene');
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
