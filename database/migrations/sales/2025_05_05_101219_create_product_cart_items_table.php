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
        Schema::create('product_cart_items', function (Blueprint $table) {
            $table->id('basket_ID');
            $table->foreignId('sale_ID')->constrained('sales', 'sale_ID')->onDelete('cascade');
            $table->foreignId('product_ID')->constrained('products', 'product_ID')->onDelete('cascade');
            $table->integer('quantity');
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
        Schema::dropIfExists('product_cart_items');
    }
};
