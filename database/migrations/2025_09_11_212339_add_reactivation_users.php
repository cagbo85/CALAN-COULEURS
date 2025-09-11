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
            $table->timestamp('reactivation_requested_at')->nullable()->after('actif');
            $table->unsignedInteger('reactivation_requested_by')->nullable()->after('reactivation_requested_at');
            $table->timestamp('reactivation_approved_at')->nullable()->after('reactivation_requested_by');
            $table->unsignedInteger('reactivation_approved_by')->nullable()->after('reactivation_approved_at');

            $table->foreign('reactivation_requested_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('reactivation_approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['reactivation_requested_by']);
            $table->dropForeign(['reactivation_approved_by']);
            $table->dropColumn([
                'reactivation_requested_at',
                'reactivation_requested_by',
                'reactivation_approved_at',
                'reactivation_approved_by'
            ]);
        });
    }
};
