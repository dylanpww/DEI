<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_ID'; 
    protected $fillable = [
        'user_id', 
        'category_id', 
        'name', 
        'actualPrice', 
        'discount', 
        'stock', 
        'status',
        'image',
        'weight_in_grams',
        'production_time',
        'production_label',
        'food_condition'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_ID');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_ID', 'product_ID');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_ID', 'product_ID');
    }
}