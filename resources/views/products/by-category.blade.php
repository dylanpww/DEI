@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-3xl shadow-sm p-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('explore') }}"
                class="text-gray-500 hover:text-crave-teal flex items-center gap-1 text-sm font-medium mb-4">
                <ion-icon name="arrow-back-outline"></ion-icon> Back to Explore
            </a>
            <h1 class="text-3xl font-extrabold text-crave-teal mb-2">{{ $category->name }}</h1>
            <p class="text-gray-600">{{ $category->description }}</p>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <form method="GET" action="{{ route('products.by-category', $category->category_id) }}" class="relative">
                <ion-icon name="search" class="absolute left-4 top-4 text-gray-400 text-xl"></ion-icon>
                <input type="text" name="search" placeholder="Search products..." value="{{ $search }}"
                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-4 pl-12 pr-4 outline-none text-md focus:ring-2 focus:ring-crave-lime focus:border-transparent transition-all shadow-inner">
            </form>
        </div>

        <!-- Products Grid -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($products as $product)
                    <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-crave-beige flex items-center justify-center overflow-hidden">
                            @php 
                                $primaryImage = $product->images->first() ? $product->images->first()->image_path : $product->image;
                                $stored = $primaryImage && file_exists(public_path('storage/' . $primaryImage)); 
                            @endphp
                            @if ($stored)
                                <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/placeholder.svg') }}" alt="No image"
                                    class="w-24 h-24 object-contain">
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-crave-teal mb-2">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mb-3">{{ $product->category->name }}</p>

                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-2xl font-bold text-crave-darkgreen">Rp
                                        {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}</p>
                                    @if ($product->discount > 0)
                                        <p class="text-xs text-gray-400 line-through">Rp
                                            {{ number_format($product->actualPrice, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-crave-lime text-crave-teal">
                                    Stock: {{ $product->stock }}
                                </span>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_ID }}">
                                <input type="hidden" name="quantity" value="1">

                                <button type="submit"
                                    class="w-full bg-crave-lime hover:bg-crave-green text-crave-teal font-bold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <ion-icon name="cart-outline"></ion-icon>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <ion-icon name="search-outline" class="text-6xl text-gray-300 mb-4"></ion-icon>
                <p class="text-gray-500 text-lg">No products found in this category.</p>
                @if ($search)
                    <p class="text-gray-400 text-sm mt-2">Try searching with different keywords.</p>
                @endif
            </div>
        @endif
    </div>
@endsection
