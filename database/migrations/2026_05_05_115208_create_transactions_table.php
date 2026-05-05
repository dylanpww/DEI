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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            
            // Link to your existing orders table
            $table->foreignId('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            
            // Midtrans-specific fields
            $table->string('midtrans_transaction_id')->nullable()->unique(); 
            $table->string('payment_type')->nullable(); // e.g., 'gopay', 'bank_transfer', 'credit_card'
            $table->decimal('gross_amount', 10, 2);
            
            // Status tracks the exact Midtrans state
            $table->string('status')->default('pending'); // Midtrans statuses: pending, settlement, cancel, expire, deny
            
            // Snap UI integration fields (highly recommended for Midtrans)
            $table->string('snap_token')->nullable();
            $table->string('snap_url')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
