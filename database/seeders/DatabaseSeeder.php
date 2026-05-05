<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            
            CategorySeeder::class, 
            ProductSeeder::class,  
        ]);

        $categories = [
            ['name' => 'Makanan', 'description' => 'Kategori untuk semua jenis makanan.'],
            ['name' => 'Minuman', 'description' => 'Kategori untuk semua jenis minuman.'],
        ];
        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }

    }
}
    