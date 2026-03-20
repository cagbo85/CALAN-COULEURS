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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('Table des utilisateurs de l\'équipe');
            $table->integer('id', true);
            $table->string('firstname')->comment('Prénom de la personne');
            $table->string('lastname')->comment('Nom de famille de la personne');
            $table->string('login')->unique('login')->comment('login de la personne');
            $table->string('email')->unique('email')->comment('Email unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('Mot de passe');
            $table->enum('role', ['super-admin', 'admin', 'editor'])->default('editor')->comment('Rôles différenciés');
            $table->string('statut')->comment('Statut de la personne au sein de l\'Association');
            $table->boolean('actif')->default(true)->comment('Utilisateur actif/inactif');
            $table->timestamp('reactivation_requested_at')->nullable()->comment('Date de demande de réactivation');
            $table->integer('reactivation_requested_by')->nullable()->index('reactivation_requested_by')->comment('ID de l\'utilisateur qui a demandé la réactivation');
            $table->timestamp('reactivation_approved_at')->nullable()->comment('Date d\'approbation de la réactivation');
            $table->integer('reactivation_approved_by')->nullable()->index('reactivation_approved_by')->comment('ID de l\'utilisateur qui a approuvé la réactivation');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
