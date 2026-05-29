<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        // Hanya vendor/admin yang bisa akses halaman produk mereka
        if (Auth::user()->role !== 'seller' && Auth::user()->role !== 'admin') {
            abort(403, 'Only sellers can manage products.');
        }
        
        // Mengambil produk milik user yang sedang login beserta data kategorinya
        $products = Product::with(['category', 'images', 'reviews'])->where('user_id', Auth::id())->get();
        $isSeller = Auth::user()->role === 'seller' || Auth::user()->role === 'admin';
        
        // --- Hitung Analitik Dasbor Toko ---
        $sellerProductIds = $products->pluck('product_ID');
        
        // Ambil semua item pesanan sukses untuk produk penjual ini
        $successfulOrderItems = \App\Models\OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function($q) {
                $q->whereIn('status', ['success', 'settlement']);
            })->get();
            
        // 1. Total Pendapatan
        $totalPendapatan = $successfulOrderItems->sum('subTotal');
        
        // 2. Total Pesanan
        $totalPesanan = $successfulOrderItems->unique('order_id')->count();
        
        // 3. Penilaian Toko
        $allReviews = collect();
        foreach($products as $product) {
            $allReviews = $allReviews->merge($product->reviews);
        }
        $avgRating = $allReviews->count() > 0 ? number_format($allReviews->avg('rating'), 1) : '0.0';
        
        // 4. Pesanan Terbaru
        $recentOrders = \App\Models\Order::whereHas('items', function($q) use ($sellerProductIds) {
            $q->whereIn('product_id', $sellerProductIds);
        })->with(['items' => function($q) use ($sellerProductIds) {
            $q->whereIn('product_id', $sellerProductIds);
        }, 'user', 'items.product'])->latest()->take(5)->get();

        return view('products.index', compact('products', 'isSeller', 'totalPendapatan', 'totalPesanan', 'avgRating', 'recentOrders'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'seller' && Auth::user()->role !== 'admin') {
            abort(403, 'Only sellers can add products.');
        }
        
        // Mengambil semua kategori untuk dropdown form
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'seller' && Auth::user()->role !== 'admin') {
            abort(403, 'Only sellers can add products.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'actualPrice' => 'required|numeric|min:0',
            'discount' => 'numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,sold_out,expired',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight_in_grams' => 'nullable|integer|min:0',
            'production_time' => 'nullable|date',
            'production_label' => 'nullable|string|max:255',
            'food_condition' => 'nullable|string|max:255',
        ]);

        $product = Product::create([
            'user_id' => Auth::id(), // Assign ke user yang sedang login
            'category_id' => $request->category_id,
            'name' => $request->name,
            'actualPrice' => $request->actualPrice,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'status' => $request->status,
            'weight_in_grams' => $request->weight_in_grams,
            'production_time' => $request->production_time,
            'production_label' => $request->production_label,
            'food_condition' => $request->food_condition,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_ID' => $product->product_ID,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images', 'reviews.user', 'user'])->findOrFail($id);
        
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'seller' && Auth::user()->role !== 'admin') {
            abort(403, 'Only sellers can edit products.');
        }
        
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'seller' && Auth::user()->role !== 'admin') {
            abort(403, 'Only sellers can update products.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'actualPrice' => 'required|numeric|min:0',
            'discount' => 'numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,sold_out,expired',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight_in_grams' => 'nullable|integer|min:0',
            'production_time' => 'nullable|date',
            'production_label' => 'nullable|string|max:255',
            'food_condition' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'actualPrice' => $request->actualPrice,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'status' => $request->status,
            'weight_in_grams' => $request->weight_in_grams,
            'production_time' => $request->production_time,
            'production_label' => $request->production_label,
            'food_condition' => $request->food_condition,
        ];

        $product->update($data);

        if ($request->hasFile('images')) {
            // Optional: delete old images if you want, but for now just add new ones
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_ID' => $product->product_ID,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'seller' && Auth::user()->role !== 'admin') {
            abort(403, 'Only sellers can delete products.');
        }
        
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function byCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $search = request('search');
        
        $query = Product::query();
        $query->where('category_id', '=', $categoryId);
        $query->where('status', '!=', 'expired');
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $products = $query->with('category')->paginate(12);
        
        return view('products.by-category', compact('category', 'products', 'search'));
    }
}