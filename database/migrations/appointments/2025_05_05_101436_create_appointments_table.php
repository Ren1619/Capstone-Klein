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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_ID');
            $table->foreignId('branch_ID')->constrained('branches', 'branch_ID')->onDelete('cascade');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('phone_number');
            $table->string('email');
            $table->date('date');
            $table->time('time');
            $table->string('appointment_type');
            $table->text('concern')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('appointments');
    }
};
