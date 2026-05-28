@extends('layouts.app')

@section('title', $product->name . ' - Crave')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="mb-6">
        <a href="{{ route('explore') }}" class="text-gray-500 hover:text-crave-teal flex items-center gap-2 font-medium">
            <ion-icon name="arrow-back-outline"></ion-icon> Kembali ke Jelajah
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
            <!-- Galeri Foto -->
            <div class="bg-crave-beige p-8 flex flex-col items-center justify-center min-h-[400px]">
                @if($product->images->count() > 0)
                    <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-inner mb-4">
                        <img id="main-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-full h-full object-cover">
                    </div>
                    @if($product->images->count() > 1)
                        <div class="flex gap-4 overflow-x-auto w-full pb-2">
                            @foreach($product->images as $img)
                                <button onclick="document.getElementById('main-image').src='{{ asset('storage/' . $img->image_path) }}'" class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden border-2 border-transparent focus:border-crave-teal transition-all">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @elseif($product->image)
                    <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-inner mb-4">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <img src="{{ asset('images/placeholder.svg') }}" class="w-48 h-48 object-contain opacity-50">
                    <p class="text-gray-400 mt-4">Tidak ada gambar</p>
                @endif
            </div>

            <!-- Detail Produk -->
            <div class="p-8 md:p-10 flex flex-col">
                <span class="text-crave-pink font-bold text-sm tracking-widest uppercase mb-2">{{ $product->category->name ?? 'Lainnya' }}</span>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-6">
                    <div>
                        <p class="text-3xl font-bold text-crave-darkgreen">Rp {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}</p>
                        @if($product->discount > 0)
                            <p class="text-sm text-gray-400 line-through">Rp {{ number_format($product->actualPrice, 0, ',', '.') }}</p>
                        @endif
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-crave-lime text-crave-darkgreen">
                        Stok: {{ $product->stock }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 mb-6 border border-gray-100 space-y-3">
                    <h3 class="font-bold text-gray-800 mb-2">Informasi Detail</h3>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Berat:</span>
                        <span class="font-semibold text-gray-800">{{ $product->weight_in_grams ? $product->weight_in_grams . ' gram' : '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Kondisi Makanan:</span>
                        <span class="font-semibold text-gray-800">{{ $product->food_condition ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Label Produksi:</span>
                        <span class="font-semibold text-gray-800">{{ $product->production_label ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Waktu Pembuatan:</span>
                        <span class="font-semibold text-gray-800">{{ $product->production_time ? \Carbon\Carbon::parse($product->production_time)->format('d M Y, H:i') : '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Penjual:</span>
                        <span class="font-semibold text-crave-teal">{{ $product->user->username ?? 'Tidak diketahui' }}</span>
                    </div>
                </div>

                <div class="mt-auto space-y-3">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_ID }}">
                        <button type="submit" class="w-full bg-crave-lime hover:bg-crave-green text-crave-darkgreen font-bold py-4 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                            <ion-icon name="cart-outline" class="text-xl"></ion-icon>
                            Tambah ke Keranjang
                        </button>
                    </form>
                    
                    @if(Auth::check() && Auth::id() !== $product->user_id)
                        <form action="{{ route('chat.start', $product->product_ID) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-white border-2 border-crave-teal text-crave-teal hover:bg-crave-teal hover:text-white font-bold py-3.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                                <ion-icon name="chatbubble-ellipses-outline" class="text-xl"></ion-icon>
                                Chat Penjual
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Review Section -->
    <livewire:product-reviews :product="$product" />
</div>
@endsection
