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
        $makananCategory = Category::where('name', 'Makanan')->first();
        $minumanCategory = Category::where('name', 'Minuman')->first();

        if ($seller) {
            // Product 1: Nasi Goreng
            $nasiGoreng = Product::create([
                'user_id' => $seller->user_ID,
                'category_id' => $makananCategory->category_id ?? 1,
                'name' => 'Nasi Goreng Spesial',
                'actualPrice' => 35000,
                'discount' => 15000,
                'stock' => 5,
                'status' => 'available',
                'weight_in_grams' => 400,
                'food_condition' => 'Baru dimasak (Kelebihan Porsi)',
                'production_label' => 'Fresh',
                'production_time' => now()->subHours(1),
            ]);
            \App\Models\ProductImage::create([
                'product_ID' => $nasiGoreng->product_ID,
                'image_path' => 'products/nasi_goreng.png',
            ]);

            // Product 2: Box of Donuts
            $donuts = Product::create([
                'user_id' => $seller->user_ID,
                'category_id' => $makananCategory->category_id ?? 1,
                'name' => 'Paket Donat Manis',
                'actualPrice' => 60000,
                'discount' => 35000,
                'stock' => 3,
                'status' => 'available',
                'weight_in_grams' => 500,
                'food_condition' => 'Sangat Baik (Sisa Stok)',
                'production_label' => 'Dibuat pagi ini',
                'production_time' => now()->subHours(6),
            ]);
            \App\Models\ProductImage::create([
                'product_ID' => $donuts->product_ID,
                'image_path' => 'products/box_donuts.png',
            ]);

            // Product 3: Iced Coffee
            $icedCoffee = Product::create([
                'user_id' => $seller->user_ID,
                'category_id' => $minumanCategory->category_id ?? 2,
                'name' => 'Es Kopi Susu Aren',
                'actualPrice' => 25000,
                'discount' => 10000,
                'stock' => 10,
                'status' => 'available',
                'weight_in_grams' => 300,
                'food_condition' => 'Dingin, Es mulai mencair',
                'production_label' => 'Dibuat 2 jam lalu',
                'production_time' => now()->subHours(2),
            ]);
            \App\Models\ProductImage::create([
                'product_ID' => $icedCoffee->product_ID,
                'image_path' => 'products/iced_coffee.png',
            ]);

            // Product 4: Mango Juice
            $mangoJuice = Product::create([
                'user_id' => $seller->user_ID,
                'category_id' => $minumanCategory->category_id ?? 2,
                'name' => 'Jus Mangga Segar',
                'actualPrice' => 20000,
                'discount' => 8000,
                'stock' => 4,
                'status' => 'available',
                'weight_in_grams' => 350,
                'food_condition' => 'Sangat Baik',
                'production_label' => 'Fresh Juice',
                'production_time' => now()->subHours(3),
            ]);
            \App\Models\ProductImage::create([
                'product_ID' => $mangoJuice->product_ID,
                'image_path' => 'products/mango_juice.png',
            ]);
        }
    }
}
