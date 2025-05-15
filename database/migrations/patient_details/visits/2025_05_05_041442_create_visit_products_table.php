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
        Schema::create('visit_products', function (Blueprint $table) {
            $table->id('visit_products_ID');
            $table->foreignId('visit_ID')->constrained('visit_history', 'visit_ID')->onDelete('cascade');
            $table->foreignId('product_ID')->constrained('products', 'product_ID')->onDelete('cascade');
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
        Schema::dropIfExists('visit_products');
    }
};
