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
        Schema::table('edition_stands', function (Blueprint $table) {
            $table->foreign(['edition_id'], 'edition_stands_ibfk_1')->references(['id'])->on('editions')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['stand_id'], 'edition_stands_ibfk_2')->references(['id'])->on('stands')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edition_stands', function (Blueprint $table) {
            $table->dropForeign('edition_stands_ibfk_1');
            $table->dropForeign('edition_stands_ibfk_2');
        });
    }
};
