<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up(): void
    {
        Schema::create('allergies', function (Blueprint $table) {
            $table->id('allergy_ID');
            $table->foreignId('PID')->constrained('patients', 'PID')->onDelete('cascade');
            $table->string('allergies');
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
        Schema::dropIfExists('allergies');
    }
};
