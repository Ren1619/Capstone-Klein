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
        Schema::create('visit_history', function (Blueprint $table) {
            $table->id('visit_ID');
            $table->foreignId('PID')->constrained('patients', 'PID')->onDelete('cascade');
            $table->timestamp('timestamp');
            $table->string('blood_pressure');
            $table->string('weight');
            $table->string('height');
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
        Schema::dropIfExists('visit_history');
    }
};
