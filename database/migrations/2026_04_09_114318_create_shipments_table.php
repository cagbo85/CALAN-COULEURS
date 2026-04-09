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
        Schema::create('shipments', function (Blueprint $table) {
            $table->comment('Expéditions des commandes');
            $table->integer('id', true);
            $table->integer('order_id')->index('shipments_ibfk_1')->comment('ID de la commande');
            $table->string('tracking_number')->nullable()->comment('Numéro de suivi du colis');
            $table->string('carrier', 100)->nullable()->comment('Transporteur');
            $table->timestamp('shipped_at')->nullable()->comment('Date et heure d\'expédition');
            $table->timestamp('delivered_at')->nullable()->comment('Date et heure de livraison');
            $table->enum('status', ['in preparation', 'shipped', 'delivered', 'returned'])->default('in preparation')->comment('Statut d\'expédition');
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
        Schema::dropIfExists('shipments');
    }
};
