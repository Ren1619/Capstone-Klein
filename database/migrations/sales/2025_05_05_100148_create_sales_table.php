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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_ID');
            $table->string('customer_name');
            $table->date('date');
            $table->decimal('subtotal_cost', 15, 2);
            $table->decimal('discount_perc', 5, 2);
            $table->decimal('total_cost', 15, 2);
            $table->boolean('finalized')->default(false);
            $table->string('branch')->default('valencia');
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
        Schema::dropIfExists('sales');
    }
};
