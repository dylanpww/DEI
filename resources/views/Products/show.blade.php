@extends('layouts.app')

@section('title', $product->name . ' - Crave')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-500 hover:text-crave-teal transition-colors font-medium">
            <ion-icon name="arrow-back-outline" class="mr-2"></ion-icon> Back to Dashboard
        </a>
        <a href="{{ route('products.edit', $product->product_ID) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors">
            <ion-icon name="create-outline" class="mr-2"></ion-icon> Edit Product
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
        <!-- Product Image -->
        <div class="md:w-1/2 bg-gray-50 flex items-center justify-center p-8">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-2xl shadow-md max-h-[500px]">
            @else
                <div class="w-full h-64 md:h-full min-h-[300px] flex flex-col items-center justify-center text-gray-400">
                    <ion-icon name="image-outline" class="text-6xl mb-4"></ion-icon>
                    <p>No image uploaded</p>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-4">
                <span class="inline-block px-3 py-1 bg-crave-beige text-crave-brown rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">{{ $product->name }}</h1>
            </div>

            <div class="mb-8">
                @if($product->discount > 0)
                    <div class="flex items-end gap-3 mb-1">
                        <span class="text-3xl font-black text-crave-pink">Rp {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}</span>
                        <span class="text-lg text-gray-400 line-through mb-1">Rp {{ number_format($product->actualPrice, 0, ',', '.') }}</span>
                    </div>
                    <span class="inline-block bg-pink-100 text-crave-pink text-xs font-bold px-2 py-1 rounded">Save Rp {{ number_format($product->discount, 0, ',', '.') }}!</span>
                @else
                    <span class="text-3xl font-black text-gray-900">Rp {{ number_format($product->actualPrice, 0, ',', '.') }}</span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase mb-1">Current Stock</p>
                    <p class="text-xl font-bold {{ $product->stock > 0 ? 'text-gray-900' : 'text-red-500' }}">{{ $product->stock }} items</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase mb-1">Status</p>
                    @if($product->status == 'available')
                        <p class="text-xl font-bold text-green-600 flex items-center"><ion-icon name="checkmark-circle" class="mr-1"></ion-icon> Available</p>
                    @elseif($product->status == 'sold_out')
                        <p class="text-xl font-bold text-red-600 flex items-center"><ion-icon name="close-circle" class="mr-1"></ion-icon> Sold Out</p>
                    @else
                        <p class="text-xl font-bold text-gray-600 flex items-center"><ion-icon name="time" class="mr-1"></ion-icon> Expired</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-auto pt-6 border-t border-gray-100 flex items-center text-sm text-gray-500">
                <ion-icon name="information-circle-outline" class="text-xl mr-2 text-crave-lime"></ion-icon>
                This is a preview of how buyers will see your product details.
            </div>
        </div>
    </div>
</div>
@endsection