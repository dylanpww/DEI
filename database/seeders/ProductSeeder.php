<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Fetch categories securely by name
        $makananCategory = Category::query()->where('name', 'Makanan')->first();
        $minumanCategory = Category::query()->where('name', 'Minuman')->first();

        if (!$makananCategory || !$minumanCategory) {
            $this->command->warn('Required categories not found! Please run CategorySeeder first.');
            return;
        }

        $seller = User::query()->where('role', 'seller')->first();

        if (!$seller) {
            $seller = User::create([
                'username' => 'Crave Partner Resto',
                'email' => 'partner@crave.test',
                'password' => Hash::make('password'),
                'role' => 'seller',
            ]);
        }

        $products = [
            [
                'user_id' => $seller->user_ID,
                'category_id' => $makananCategory->category_id,
                'name' => 'Nasi Kebuli Jos',
                'actualPrice' => 45000.00,
                'discount' => 10000.00,
                'stock' => 5,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],
            [
                'user_id' => $seller->user_ID,
                'category_id' => $makananCategory->category_id,
                'name' => 'Ayam Geprek Sisa Kemarin',
                'actualPrice' => 25000.00,
                'discount' => 10000.00,
                'stock' => 3,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],
            [
                'user_id' => $seller->user_ID,
                'category_id' => $makananCategory->category_id,
                'name' => 'Roti Tawar Hampir Expired',
                'actualPrice' => 20000.00,
                'discount' => 12000.00,
                'stock' => 8,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],

            // --- DRINKS (MINUMAN) ---
            [
                'user_id' => $seller->user_ID,
                'category_id' => $minumanCategory->category_id, // Original Drink
                'name' => 'Es Campur Segar',
                'actualPrice' => 15000.00,
                'discount' => 5000.00,
                'stock' => 10,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],
            [
                'user_id' => $seller->user_ID,
                'category_id' => $minumanCategory->category_id, // New Drink 1
                'name' => 'Es Kopi Susu Gula Aren',
                'actualPrice' => 22000.00,
                'discount' => 7000.00,
                'stock' => 15,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],
            [
                'user_id' => $seller->user_ID,
                'category_id' => $minumanCategory->category_id, // New Drink 2
                'name' => 'Jus Alpukat Kental',
                'actualPrice' => 18000.00,
                'discount' => 6000.00,
                'stock' => 5,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],
            [
                'user_id' => $seller->user_ID,
                'category_id' => $minumanCategory->category_id, // New Drink 3
                'name' => 'Es Teh Manis Jumbo',
                'actualPrice' => 10000.00,
                'discount' => 4000.00,
                'stock' => 20,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],
            [
                'user_id' => $seller->user_ID,
                'category_id' => $minumanCategory->category_id, // New Drink 4
                'name' => 'Matcha Latte Dingin',
                'actualPrice' => 28000.00,
                'discount' => 10000.00,
                'stock' => 8,
                'status' => 'available',
                'image' => 'products/makan.png'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
