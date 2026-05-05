<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $products = Product::with('category')->where('user_id', Auth::id())->get();
        $isSeller = Auth::user()->role === 'seller' || Auth::user()->role === 'admin';
        return view('products.index', compact('products', 'isSeller'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id' => Auth::id(), // Assign ke user yang sedang login
            'category_id' => $request->category_id,
            'name' => $request->name,
            'actualPrice' => $request->actualPrice,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        // Pastikan user tidak bisa melihat detail produk orang lain (hanya vendor/admin punya produk)
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'actualPrice' => $request->actualPrice,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product->update($data);

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