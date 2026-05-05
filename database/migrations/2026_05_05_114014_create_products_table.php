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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_ID');
            $table->foreignId('user_id')->references('user_ID')->on('users')->onDelete('cascade');
            $table->foreignId('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->string('name');
            $table->decimal('actualPrice', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->integer('stock');
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
