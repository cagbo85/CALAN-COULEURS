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
        Schema::table('products_variants', function (Blueprint $table) {
            $table->foreign(['created_by'], 'products_variants_ibfk_1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['updated_by'], 'products_variants_ibfk_2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['product_id'], 'products_variants_ibfk_3')->references(['id'])->on('products')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['size_id'], 'products_variants_ibfk_4')->references(['id'])->on('sizes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['color_id'], 'products_variants_ibfk_5')->references(['id'])->on('colors')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_variants', function (Blueprint $table) {
            $table->dropForeign('products_variants_ibfk_1');
            $table->dropForeign('products_variants_ibfk_2');
            $table->dropForeign('products_variants_ibfk_3');
            $table->dropForeign('products_variants_ibfk_4');
            $table->dropForeign('products_variants_ibfk_5');
        });
    }
};
