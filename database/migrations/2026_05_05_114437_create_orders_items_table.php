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
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id('orders_item_id');
            $table->foreignId('order_id')->references('order_id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('orders_items');
    }
};
