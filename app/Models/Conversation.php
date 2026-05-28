<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['buyer_id', 'seller_id', 'product_ID'];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'user_ID');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'user_ID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_ID', 'product_ID');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }
}
