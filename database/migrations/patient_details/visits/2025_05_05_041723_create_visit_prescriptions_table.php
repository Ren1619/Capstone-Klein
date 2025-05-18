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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id('prescription_ID');
            $table->foreignId('medication_ID')->constrained('medications', 'medication_ID')->onDelete('cascade');
            $table->string('medication_name')->nullable();
            $table->foreignId('visit_ID')->constrained('visit_history', 'visit_ID')->onDelete('cascade');
            $table->timestamp('timestamp');
            $table->string('dosage');
            $table->string('frequency');
            $table->string('duration');
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
        Schema::dropIfExists('visit_prescriptions');
    }
};
