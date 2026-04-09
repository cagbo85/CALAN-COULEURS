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
        Schema::create('edition_stands', function (Blueprint $table) {
            $table->comment('Association entre les éditions et les stands');
            $table->integer('edition_id');
            $table->integer('stand_id')->index('edition_stands_ibfk_2');
            $table->boolean('actif')->default(true)->comment('Stand actif/masqué');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Date de création');

            $table->primary(['edition_id', 'stand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edition_stands');
    }
};
