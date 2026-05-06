<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_ID'; 

    protected $fillable = [
        'user_ID',
        'product_ID',
        'rating',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID', 'user_ID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_ID', 'product_ID');
    }
}