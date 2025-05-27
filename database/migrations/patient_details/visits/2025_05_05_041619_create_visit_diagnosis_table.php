<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     
    public function up(): void
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id('diagnosis_ID');
            $table->foreignId('account_ID')->constrained('accounts', 'account_ID')->onDelete('cascade');
            $table->foreignId('visit_ID')->constrained('visit_history', 'visit_ID')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnosis');
    }
};
