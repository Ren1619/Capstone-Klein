<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id('branch_ID');
            $table->string('name');
            $table->text('address');
            $table->string('contact');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('operating_days_from');
            $table->string('operating_days_to');
            $table->string('operating_hours_start');
            $table->string('operating_hours_end');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('branches');
    }
};