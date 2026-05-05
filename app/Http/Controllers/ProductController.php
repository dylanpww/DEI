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
        // Mengambil produk milik user yang sedang login beserta data kategorinya
        $products = Product::with('category')->where('user_id', Auth::id())->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Mengambil semua kategori untuk dropdown form
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'actualPrice' => 'required|numeric|min:0',
            'discount' => 'numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,sold_out,expired',
        ]);

        Product::create([
            'user_id' => Auth::id(), // Assign ke user yang sedang login
            'category_id' => $request->category_id,
            'name' => $request->name,
            'actualPrice' => $request->actualPrice,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'status' => $request->status,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        // Pastikan user tidak bisa melihat detail produk orang lain (opsional)
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'actualPrice' => 'required|numeric|min:0',
            'discount' => 'numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,sold_out,expired',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}