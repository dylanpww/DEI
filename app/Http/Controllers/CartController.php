<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        // Ambil data keranjang dari session, jadikan koleksi objek agar bisa dibaca oleh Blade
        $cartData = session()->get('cart', []);
        
        $cartItems = collect($cartData)->map(function ($item) {
            return (object) $item; // Ubah array menjadi objek
        });

        // Hitung total harga
        $totalPrice = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        // Kirim data ke tampilan cart.blade.php
        return view('cart', compact('cartItems', 'totalPrice'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
        ]);

        // Cari produk dari database
        $product = Product::where('product_id', $request->product_id)->firstOrFail();

        // Ambil keranjang saat ini dari session
        $cart = session()->get('cart', []);

        // Jika barang sudah ada di keranjang, tambah quantity-nya
        if (isset($cart[$product->product_id])) {
            $cart[$product->product_id]['quantity']++;
        } else {
            // Jika belum ada, masukkan sebagai barang baru
            $cart[$product->product_id] = [
                'id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->actualPrice - $product->discount, // Harga setelah diskon
                'image_url' => $product->image ? asset('storage/' . $product->image) : '',
                'unit' => '1 pcs', // Bisa disesuaikan dengan field di DB Anda
                'quantity' => 1
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Barang berhasil ditambahkan!');
    }
}