@extends('layouts.app')

@section('title', 'Add New Product - Crave')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('products.index') }}" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-crave-teal transition-colors">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900">Add New Product</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-crave-lime transition-colors bg-gray-50">
                    <div class="space-y-1 text-center">
                        <ion-icon name="image-outline" class="mx-auto h-12 w-12 text-gray-400"></ion-icon>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-crave-teal hover:text-crave-darkgreen focus-within:outline-none px-2 py-1">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border" placeholder="e.g. Surplus Blueberry Muffins">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                    <select name="category_id" id="category_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border bg-white">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border bg-white">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="actualPrice" class="block text-sm font-semibold text-gray-700 mb-1">Actual Price (Rp)</label>
                    <input type="number" name="actualPrice" id="actualPrice" value="{{ old('actualPrice') }}" required min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border">
                    @error('actualPrice') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Discount -->
                <div>
                    <label for="discount" class="block text-sm font-semibold text-gray-700 mb-1">Discount Amount (Rp)</label>
                    <input type="number" name="discount" id="discount" value="{{ old('discount', 0) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border">
                    @error('discount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Stock Quantity</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border">
                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-crave-green hover:bg-crave-darkgreen text-white font-bold rounded-xl transition-colors shadow-md">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection