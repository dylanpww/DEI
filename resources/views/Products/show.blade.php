@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-8 border border-gray-100">
    <div class="mb-8 flex justify-between items-center border-b border-gray-100 pb-4">
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-crave-teal flex items-center gap-1 text-sm font-medium">
            <ion-icon name="arrow-back-outline"></ion-icon> Back to Products
        </a>
        <div class="flex gap-2">
            <a href="{{ route('products.edit', $product->product_ID) }}" class="bg-crave-orange hover:bg-crave-brown text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                <ion-icon name="create-outline"></ion-icon> Edit
            </a>
            <form action="{{ route('products.destroy', $product->product_ID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-crave-pink hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                    <ion-icon name="trash-outline"></ion-icon> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
            <div class="mb-6 flex items-center gap-3">
                <div class="h-12 w-12 bg-crave-lime text-crave-teal rounded-full flex items-center justify-center text-2xl">
                    <ion-icon name="restaurant-outline"></ion-icon>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-crave-teal">{{ $product->name }}</h2>
                    <p class="text-crave-darkgreen font-medium">{{ $product->category->name ?? 'Uncategorized' }}</p>
                </div>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-500 mb-1">Status</p>
                <span class="px-4 py-2 rounded-full text-sm font-bold {{ $product->status == 'available' ? 'bg-crave-lime text-crave-teal' : 'bg-gray-200 text-gray-500' }}">
                    {{ ucfirst($product->status) }}
                </span>
            </div>
        </div>

        <div class="bg-crave-beige/30 p-6 rounded-2xl border border-crave-beige">
            <div class="mb-6">
                <p class="text-sm text-gray-500 font-medium mb-1">Pricing Details</p>
                @if($product->discount > 0)
                    <div class="text-gray-400 line-through text-lg">Rp {{ number_format($product->actualPrice, 0, ',', '.') }}</div>
                    <div class="text-4xl font-extrabold text-crave-teal">
                        Rp {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-crave-pink font-bold mt-1">Discount: -Rp {{ number_format($product->discount, 0, ',', '.') }}</div>
                @else
                    <div class="text-4xl font-extrabold text-crave-teal">
                        Rp {{ number_format($product->actualPrice, 0, ',', '.') }}
                    </div>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Current Stock</p>
                <div class="text-2xl font-bold text-crave-brown">
                    {{ $product->stock }} <span class="text-lg font-normal">items available</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection