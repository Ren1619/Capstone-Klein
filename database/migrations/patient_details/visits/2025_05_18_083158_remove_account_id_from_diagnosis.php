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
        Schema::table('diagnosis', function (Blueprint $table) {
            // First drop the foreign key constraint
            $table->dropForeign(['account_ID']);
            // Then drop the column
            $table->dropColumn('account_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->foreignId('account_ID')->nullable()->constrained('accounts', 'account_ID')->onDelete('cascade');
        });
    }
};
