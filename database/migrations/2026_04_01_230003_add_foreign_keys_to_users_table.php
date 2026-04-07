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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['updated_by'], 'users_ibfk_1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['reactivation_requested_by'], 'users_ibfk_2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['reactivation_approved_by'], 'users_ibfk_3')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_ibfk_1');
            $table->dropForeign('users_ibfk_2');
            $table->dropForeign('users_ibfk_3');
        });
    }
};
