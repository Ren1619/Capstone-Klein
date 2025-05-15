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
         Schema::create('patients', function (Blueprint $table) {
             $table->id('PID');
             $table->string('last_name');
             $table->string('first_name');
             $table->string('middle_name')->nullable();
             $table->text('address')->nullable();
             $table->enum('sex', ['Male', 'Female', 'Other']);
             $table->date('date_of_birth');
             $table->string('contact_number')->nullable();
             $table->string('email')->nullable()->unique();
             $table->string('civil_status')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
