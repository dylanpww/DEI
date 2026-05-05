@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-8 border border-gray-100">
    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-crave-teal flex items-center gap-1 text-sm font-medium mb-4">
            <ion-icon name="arrow-back-outline"></ion-icon> Back to Products
        </a>
        <h2 class="text-2xl font-extrabold text-crave-teal">Add New Product</h2>
    </div>

    <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Product Name</label>
            <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-crave-lime">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                <select name="category_id" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-crave-lime">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                <select name="status" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-crave-lime">
                    <option value="available">Available</option>
                    <option value="sold_out">Sold Out</option>
                    <option value="expired">Expired</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Actual Price (Rp)</label>
                <input type="number" name="actualPrice" required min="0" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-crave-lime">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Discount (Rp)</label>
                <input type="number" name="discount" value="0" min="0" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-crave-lime">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Stock</label>
                <input type="number" name="stock" required min="0" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-crave-lime">
            </div>
        </div>
        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-crave-darkgreen hover:bg-crave-teal text-white font-bold py-3 px-8 rounded-lg transition-colors shadow-md">
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection