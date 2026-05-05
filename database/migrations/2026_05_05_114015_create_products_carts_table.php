<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products_carts', function (Blueprint $table) {

            $table->id('product_cart_id');
            $table->foreignId('cart_id')->references('cart_id')->on('carts')->onDelete('cascade');
            $table->foreignId('product_id')->references('product_ID')->on('products')->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('subTotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_carts');
    }
};
