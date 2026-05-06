<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'orders_items';

    protected $primaryKey = 'orders_item_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'subTotal',
    ];

    /**
     * Relasi balik ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * Relasi ke Produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_ID');
    }
}