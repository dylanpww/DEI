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
        if (Auth::check() && Auth::user()->role !== 'user') {
            return redirect()->route('explore')->with('error', 'Penjual tidak dapat melakukan pembelian.');
        }

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
        if (Auth::check() && Auth::user()->role !== 'user') {
            return redirect()->route('explore')->with('error', 'Penjual tidak dapat melakukan pembelian.');
        }

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
                'image_url' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : ($product->image ? asset('storage/' . $product->image) : ''),
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
        if (Auth::check() && Auth::user()->role !== 'user') {
            return redirect()->route('explore')->with('error', 'Penjual tidak dapat melakukan pembelian.');
        }

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
        $subtotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
        $deliveryFee = 10000;
        $totalPrice = $subtotal + $deliveryFee;

        // 1. Buat data Order
        $order = Order::create([
            'user_id'    => Auth::user()->user_ID,
            'address_ID' => $addressId,
            'totalPrice' => $totalPrice,
            'status'     => 'success',
        ]);

        // 2. Simpan item dan kurangi stok
        foreach ($cart as $id => $details) {
            // Buat record item pesanan
            OrderItem::create([
                'order_id'   => $order->order_id,
                'product_id' => $id,
                'qty'        => $details['quantity'],
                'subTotal'   => $details['price'] * $details['quantity'],
            ]);

            // --- PROSES PENGURANGAN STOK ---
            $product = \App\Models\Product::find($id);
            if ($product) {
                $product->stock -= $details['quantity'];
                if ($product->stock <= 0) {
                    $product->status = 'sold_out';
                }
                $product->save();

                // INIT CHAT
                if ($product->user_id !== \Illuminate\Support\Facades\Auth::id()) {
                    $conversation = \App\Models\Conversation::firstOrCreate([
                        'buyer_id' => \Illuminate\Support\Facades\Auth::id(),
                        'seller_id' => $product->user_id,
                        'product_ID' => $product->product_ID,
                        'order_id' => $order->order_id,
                    ]);
                    
                    $messageCount = \App\Models\Message::where('conversation_id', $conversation->id)->count();
                    if ($messageCount === 0) {
                        \App\Models\Message::create([
                            'conversation_id' => $conversation->id,
                            'sender_id' => \Illuminate\Support\Facades\Auth::id(),
                            'message' => 'Halo, saya baru saja memesan produk ini. Mohon proses pesanan saya. Terima kasih!',
                            'is_read' => false,
                        ]);
                    }
                }
            }
            // -------------------------------
        }

        DB::commit();

        session()->forget(['cart', 'selected_address_id']);

        return redirect()->route('my-transactions')->with('success', 'Payment successful! Your order is being processed.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('cart')->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
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