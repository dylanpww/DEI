<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

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

        $selectedAddress = null;

        if (Auth::check()) {
        // 1. Ambil ID dari session
        $sessionAddressId = session()->get('selected_address_id');

        if ($sessionAddressId) {
            // Cari alamat yang ID-nya cocok dengan session DAN milik user tersebut
            $selectedAddress = Address::where('Address_ID', $sessionAddressId)
            ->where('user_ID', Auth::id())
            ->first();
        }

        // 2. Jika di session tidak ada (atau alamat lama sudah dihapus), 
        // ambil alamat yang paling baru ditambahkan (terakhir dibuat)
        if (!$selectedAddress) {
            $selectedAddress = Address::where('user_ID', Auth::id())
            ->latest() // Mengambil yang paling baru
            ->first();
            
            // Simpan otomatis ke session agar sinkron
            if ($selectedAddress) {
                session()->put('selected_address_id', $selectedAddress->Address_ID);
            }
        }
    }

        // Kirim data ke tampilan cart.blade.php
        return view('cart', compact('cartItems', 'totalPrice', 'selectedAddress'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
        ]);
        
        $product = Product::findOrFail($request->product_id);

        // Ambil keranjang saat ini dari session
        $cart = session()->get('cart', []);

        // Use the model's primary key `product_ID` as the cart key
        $pid = $product->product_ID;

        // Jika barang sudah ada di keranjang, tambah quantity-nya
        if (isset($cart[$pid])) {
            $cart[$pid]['quantity']++;
        } else {
            // Jika belum ada, masukkan sebagai barang baru
            $cart[$pid] = [
                'id' => $pid,
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

    public function selectAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,Address_ID'
        ]);

        // Simpan pilihan ke session
        session()->put('selected_address_id', $request->address_id);

        return redirect()->route('cart')->with('success', 'Delivery address updated!');
    }

    public function increase(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        $cart = session()->get('cart', []);
        $pid = $request->product_id;
        if (isset($cart[$pid])) {
            $cart[$pid]['quantity']++;
            session()->put('cart', $cart);
        }
        return redirect()->route('cart');
    }

    public function decrease(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        $cart = session()->get('cart', []);
        $pid = $request->product_id;
        if (isset($cart[$pid])) {
            $cart[$pid]['quantity']--;
            if ($cart[$pid]['quantity'] <= 0) {
                unset($cart[$pid]);
            }
            session()->put('cart', $cart);
        }
        return redirect()->route('cart');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        $cart = session()->get('cart', []);
        $pid = $request->product_id;
        if (isset($cart[$pid])) {
            unset($cart[$pid]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart');
    }
}