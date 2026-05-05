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
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_ID');
    }
}