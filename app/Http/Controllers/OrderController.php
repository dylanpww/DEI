<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with(['items.product.images', 'items.product.reviews' => function($query) {
        $query->where('user_ID', Auth::user()->user_ID);
    }, 'transaction'])
    ->where('user_id', Auth::user()->user_ID)
    ->latest()
    ->get();

    return view('myTransaction', compact('orders'));
}
}