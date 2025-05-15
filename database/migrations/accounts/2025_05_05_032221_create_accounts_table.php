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

     
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('account_ID'); // Primary Key: account_ID
            $table->foreignId('role_ID')->constrained('accounts_role', 'role_ID')->onDelete('cascade'); // Foreign Key: role_ID (links to roles table)
            $table->foreignId('branch_ID')->constrained('branches', 'branch_ID')->onDelete('cascade'); // Foreign Key: branch_ID (links to branches table)
            $table->string('last_name');
            $table->string('first_name');
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('password');
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
        Schema::dropIfExists('accounts');
    }
};
