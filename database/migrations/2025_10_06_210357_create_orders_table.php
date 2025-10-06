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
            $table->string('helloasso_id', 100)->comment('ID de la commande HelloAsso');
            $table->string('shipping_tracking_number')->nullable()->comment('Numéro de suivi du colis');
            $table->string('shipping_carrier', 100)->nullable()->comment('Transporteur');
            $table->date('shipping_date')->nullable()->comment('Date d\'expédition');
            $table->date('delivered_date')->nullable()->comment('Date de livraison');
            $table->enum('shipping_status', ['in preparation', 'shipped', 'delivered', 'returned'])->nullable()->default('in preparation')->comment('Statut d\'expédition');
            $table->enum('status', ['pending', 'paid', 'shipped', 'cancelled', 'refunded'])->default('pending')->comment('Statut de la commande');
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
