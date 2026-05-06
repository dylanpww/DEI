<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Transaction;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'address_ID',
        'totalPrice',
        'status',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_ID');
    }

    /**
     * Relasi ke Alamat
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_ID', 'Address_ID');
    }

    /**
     * Relasi ke Item Pesanan (Satu order punya banyak barang)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    /**
     * Relasi ke Transaksi (Midtrans)
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id', 'order_id');
    }
}