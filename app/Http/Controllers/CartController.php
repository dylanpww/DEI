<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
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

    public function checkout()
    {
        $cartData = session()->get('cart', []);
        
        // Jika keranjang kosong, kembalikan ke halaman cart
        if (empty($cartData)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $cartItems = collect($cartData)->map(function ($item) {
            return (object) $item;
        });

        $totalPrice = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        // Ambil alamat yang dipilih
        $selectedAddressId = session()->get('selected_address_id');
        $selectedAddress = null;

        if ($selectedAddressId) {
            $selectedAddress = \App\Models\Address::where('Address_ID', $selectedAddressId)
            ->where('user_ID', \Illuminate\Support\Facades\Auth::id())
            ->first();
        }

        // VALIDASI: Cegah masuk ke checkout jika belum memilih alamat
        if (!$selectedAddress) {
            return redirect()->route('cart')->with('error', 'Please select a delivery address before checking out.');
        }

        // Kirim data ke tampilan checkout
        return view('checkout', compact('cartItems', 'totalPrice', 'selectedAddress'));
    }

    public function process(Request $request)
{
    $cart = session()->get('cart', []);
    $addressId = session()->get('selected_address_id');

    if (empty($cart) || !$addressId) {
        return redirect()->route('cart')->with('error', 'Cart is empty or address not selected.');
    }

    DB::beginTransaction();

    try {
        // 1. Hitung total (sesuaikan dengan tampilan kamu yang ada biaya ongkir 10.000)
        $subtotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
        $deliveryFee = 10000;
        $totalPrice = $subtotal + $deliveryFee;

        // 2. Buat data Order
        $order = Order::create([
            'user_id'    => Auth::user()->user_ID,
            'address_ID' => $addressId,
            'totalPrice' => $totalPrice,
            'status'     => 'success', // UBAH DARI 'pending' MENJADI 'success'
        ]);

        // 3. Simpan item-itemnya
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id'   => $order->order_id,
                'product_id' => $id,
                'qty'        => $details['quantity'],
                'subTotal'   => $details['price'] * $details['quantity'],
            ]);

            // OPSIONAL: Kurangi stok produk di sini jika perlu
            // $product = Product::find($id);
            // $product->decrement('stock', $details['quantity']);
        }

        DB::commit();

        // 4. Bersihkan session
        session()->forget(['cart', 'selected_address_id']);

        // 5. Redirect ke halaman transaksi (my-transactions) dengan pesan sukses
        return redirect()->route('my-transactions')->with('success', 'Payment successful! Your order is being processed.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to process payment: ' . $e->getMessage());
    }
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