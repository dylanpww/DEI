<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'seller' || Auth::user()->role === 'admin') {
            $sellerId = Auth::user()->user_ID;
            // Get orders that contain items belonging to this seller
            $orders = Order::whereHas('items.product', function($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })->with(['items' => function($q) use ($sellerId) {
                // Eager load only items belonging to this seller
                $q->whereHas('product', function($q2) use ($sellerId) {
                    $q2->where('user_id', $sellerId);
                });
            }, 'items.product.images', 'transaction', 'user'])
            ->latest()
            ->get();
        } else {
            $orders = Order::with(['items.product.images', 'items.product.reviews' => function($query) {
                $query->where('user_ID', Auth::user()->user_ID);
            }, 'transaction'])
            ->where('user_id', Auth::user()->user_ID)
            ->latest()
            ->get();
        }

        return view('myTransaction', compact('orders'));
    }
}