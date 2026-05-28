<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = User::where('email', 'partner@crave.com')->first();
        $category = Category::first();

        if ($seller && $category) {
            Product::create([
                'user_id' => $seller->user_ID,
                'category_id' => $category->id ?? 1,
                'name' => 'Paket Donat Sisa Hari Ini',
                'actualPrice' => 60000,
                'discount' => 35000,
                'stock' => 5,
                'status' => 'available',
                'weight_in_grams' => 500,
                'food_condition' => 'Sangat Baik (Sisa Stok)',
                'production_label' => 'Dibuat pagi ini',
                'production_time' => now()->subHours(6),
            ]);

            Product::create([
                'user_id' => $seller->user_ID,
                'category_id' => $category->id ?? 1,
                'name' => 'Nasi Goreng Spesial',
                'actualPrice' => 35000,
                'discount' => 15000,
                'stock' => 2,
                'status' => 'available',
                'weight_in_grams' => 300,
                'food_condition' => 'Baru dimasak',
                'production_label' => 'Fresh',
                'production_time' => now()->subHours(1),
            ]);
        }
    }
}
