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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_ID');
            
            $table->foreignId('user_ID')->references('user_ID')->on('users')->onDelete('cascade');
            
            $table->foreignId('product_ID')->references('product_ID')->on('products')->onDelete('cascade');
            
            $table->integer('rating');
            $table->text('comment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
