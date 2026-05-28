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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('weight_in_grams')->nullable()->after('stock');
            $table->dateTime('production_time')->nullable()->after('weight_in_grams');
            $table->string('production_label')->nullable()->after('production_time');
            $table->string('food_condition')->nullable()->after('production_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight_in_grams', 'production_time', 'production_label', 'food_condition']);
        });
    }
};
