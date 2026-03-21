<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->foreign(['edition_id'], 'performances_ibfk_1')->references(['id'])->on('editions')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['artiste_id'], 'performances_ibfk_2')->references(['id'])->on('artistes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['created_by'], 'performances_ibfk_3')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['updated_by'], 'performances_ibfk_4')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->dropForeign('performances_ibfk_1');
            $table->dropForeign('performances_ibfk_2');
            $table->dropForeign('performances_ibfk_3');
            $table->dropForeign('performances_ibfk_4');
        });
    }
};
