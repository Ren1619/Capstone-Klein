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
        Schema::table('prescriptions', function (Blueprint $table) {
            // First drop the foreign key constraint
            $table->dropForeign(['medication_ID']);
            
            // Then drop the column
            $table->dropColumn('medication_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            // Add the column back
            $table->foreignId('medication_ID')->nullable()->constrained('medications', 'medication_ID')->onDelete('cascade');
        });
    }
};