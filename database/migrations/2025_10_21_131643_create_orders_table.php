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
        Schema::create('orders', function (Blueprint $table) {
            $table->comment('Commandes passées sur la boutique en ligne');
            $table->integer('id', true);
            $table->string('email')->comment('Email du client');
            $table->string('firstname')->comment('Prénom du client');
            $table->string('lastname')->comment('Nom de famille du client');
            $table->string('adresse')->nullable()->comment('Adresse complète (numéro et rue)');
            $table->string('ville', 100)->nullable()->comment('Ville');
            $table->string('departement', 100)->nullable()->comment('Département ou région');
            $table->string('code_postal', 20)->nullable()->comment('Code postal');
            $table->string('pays', 100)->nullable()->comment('Pays');
            $table->decimal('total_amount', 10)->comment('Montant total de la commande en euros');
            $table->string('helloasso_id', 100)->nullable()->comment('ID de la commande HelloAsso');
            $table->string('payment_status', 50)->nullable();
            $table->string('cashout_state', 100)->nullable();
            $table->string('helloasso_payment_id', 100)->nullable()->comment('ID du paiement HelloAsso');
            $table->timestamp('paid_at')->nullable()->comment('Date et heure du paiement');
            $table->json('payment_metadata')->nullable()->comment('Métadonnées du paiement (stockées en JSON)');
            $table->string('token')->comment('Token unique pour accéder à la commande');
            $table->boolean('stock_decremented')->default(false)->comment('Indique si le stock a été décrémenté pour cette commande');
            $table->enum('status', ['pending', 'paid', 'shipped', 'delivered', 'cancelled', 'refunded'])->default('pending')->comment('Statut de la commande');
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
        Schema::dropIfExists('orders');
    }
};
