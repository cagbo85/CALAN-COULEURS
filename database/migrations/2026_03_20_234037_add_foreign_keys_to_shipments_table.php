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
        Schema::table('shipments', function (Blueprint $table) {
            $table->foreign(['order_id'], 'shipments_ibfk_1')->references(['id'])->on('orders')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['created_by'], 'shipments_ibfk_2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['updated_by'], 'shipments_ibfk_3')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign('shipments_ibfk_1');
            $table->dropForeign('shipments_ibfk_2');
            $table->dropForeign('shipments_ibfk_3');
        });
    }
};
