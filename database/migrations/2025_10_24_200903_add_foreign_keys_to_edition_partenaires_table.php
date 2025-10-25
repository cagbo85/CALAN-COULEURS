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
        Schema::table('edition_partenaires', function (Blueprint $table) {
            $table->foreign(['edition_id'], 'edition_partenaires_ibfk_1')->references(['id'])->on('editions')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['partenaire_id'], 'edition_partenaires_ibfk_2')->references(['id'])->on('partenaires')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edition_partenaires', function (Blueprint $table) {
            $table->dropForeign('edition_partenaires_ibfk_1');
            $table->dropForeign('edition_partenaires_ibfk_2');
        });
    }
};
