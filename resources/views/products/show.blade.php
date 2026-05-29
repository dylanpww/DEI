@extends('layouts.app')

@section('title', $product->name . ' - Crave')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="mb-6">
        <a href="{{ route('explore') }}" class="text-gray-500 hover:text-crave-teal flex items-center gap-2 font-medium">
            <ion-icon name="arrow-back-outline"></ion-icon> Kembali ke Jelajah
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 overflow-hidden mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
            <!-- Galeri Foto -->
            <div class="bg-gradient-to-br from-crave-beige to-white p-8 md:p-12 flex flex-col items-center justify-center min-h-[400px] border-r border-gray-50">
                @if($product->images->count() > 0)
                    <div class="w-full aspect-square rounded-[2rem] overflow-hidden shadow-2xl mb-6 relative group">
                        <img id="main-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    </div>
                    @if($product->images->count() > 1)
                        <div class="flex gap-4 overflow-x-auto w-full pb-2 no-scrollbar px-2">
                            @foreach($product->images as $img)
                                <button onclick="document.getElementById('main-image').src='{{ asset('storage/' . $img->image_path) }}'" class="w-20 h-20 flex-shrink-0 rounded-2xl overflow-hidden shadow-md border-2 border-transparent focus:border-crave-teal hover:scale-105 transition-all">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @elseif($product->image)
                    <div class="w-full aspect-square rounded-[2rem] overflow-hidden shadow-2xl mb-4 group">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                @else
                    <div class="w-full aspect-square rounded-[2rem] bg-gray-50 flex flex-col items-center justify-center mb-4">
                        <img src="{{ asset('images/placeholder.svg') }}" class="w-32 h-32 object-contain opacity-30">
                        <p class="text-gray-400 mt-4 font-medium">Tidak ada gambar</p>
                    </div>
                @endif
            </div>

            <!-- Detail Produk -->
            <div class="p-8 md:p-12 flex flex-col relative bg-white">
                <div class="absolute top-0 right-0 w-32 h-32 bg-crave-lime/10 rounded-bl-full pointer-events-none"></div>
                
                <span class="inline-block px-4 py-1.5 rounded-full bg-crave-pink/10 text-crave-pink font-bold text-xs tracking-widest uppercase mb-4 w-fit border border-crave-pink/20">{{ $product->category->name ?? 'Lainnya' }}</span>
                <h1 class="text-4xl font-black text-gray-900 mb-4 tracking-tight drop-shadow-sm">{{ $product->name }}</h1>
                
                @php
                    $avgRating = $product->reviews->avg('rating') ?? 0;
                    $reviewCount = $product->reviews->count();
                @endphp
                @if($reviewCount > 0)
                <div class="flex items-center gap-2 mb-6 -mt-2">
                    <div class="flex items-center gap-1 bg-crave-orange/10 px-3 py-1 rounded-lg border border-crave-orange/20">
                        <ion-icon name="star" class="text-crave-orange text-lg"></ion-icon>
                        <span class="font-bold text-gray-900">{{ number_format($avgRating, 1) }}</span>
                    </div>
                    <a href="#reviews" class="text-gray-500 hover:text-crave-teal font-medium text-sm underline decoration-gray-300 hover:decoration-crave-teal transition-colors">({{ $reviewCount }} Ulasan)</a>
                </div>
                @endif
                
                <div class="flex items-end gap-4 mb-8 pb-8 border-b border-gray-100">
                    <div>
                        <p class="text-sm text-gray-400 font-bold mb-1 uppercase tracking-wide">Harga Spesial</p>
                        <div class="flex items-baseline gap-3">
                            <p class="text-4xl font-black text-crave-darkgreen drop-shadow-sm">Rp {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}</p>
                            @if($product->discount > 0)
                                <p class="text-lg text-gray-400 line-through font-semibold">Rp {{ number_format($product->actualPrice, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="ml-auto">
                        <span class="px-5 py-2 rounded-xl text-sm font-bold bg-crave-lime/20 text-crave-darkgreen border border-crave-lime/30 shadow-sm">
                            Sisa: {{ $product->stock }}
                        </span>
                    </div>
                </div>

                <div class="bg-gray-50/50 rounded-2xl p-6 mb-8 border border-gray-100 space-y-4">
                    <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                        <ion-icon name="information-circle-outline" class="text-crave-teal"></ion-icon> Informasi Detail
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <span class="block text-xs text-gray-400 font-bold mb-1 uppercase">Berat</span>
                            <span class="font-bold text-gray-800">{{ $product->weight_in_grams ? $product->weight_in_grams . ' gram' : '-' }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <span class="block text-xs text-gray-400 font-bold mb-1 uppercase">Kondisi</span>
                            <span class="font-bold text-gray-800">{{ $product->food_condition ?: '-' }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <span class="block text-xs text-gray-400 font-bold mb-1 uppercase">Label Produksi</span>
                            <span class="font-bold text-gray-800">{{ $product->production_label ?: '-' }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <span class="block text-xs text-gray-400 font-bold mb-1 uppercase">Waktu Pembuatan</span>
                            <span class="font-bold text-gray-800">{{ $product->production_time ? \Carbon\Carbon::parse($product->production_time)->format('d M Y, H:i') : '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-white to-gray-50 p-4 rounded-xl border border-gray-100 shadow-sm flex justify-between items-center mt-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-crave-teal text-white rounded-full flex items-center justify-center font-bold shadow-md">
                                {{ strtoupper(substr($product->user->username ?? 'T', 0, 1)) }}
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 font-bold uppercase">Dijual Oleh</span>
                                <span class="font-bold text-crave-teal text-lg">{{ $product->user->username ?? 'Tidak diketahui' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-auto space-y-4">
                    @if(!Auth::check() || (Auth::check() && in_array(Auth::user()->role, ['user', 'admin'])))
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_ID }}">
                        <button type="submit" class="w-full bg-gradient-to-r from-crave-lime to-crave-green hover:from-crave-green hover:to-crave-darkgreen text-crave-darkgreen hover:text-white font-black py-4 rounded-2xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 flex items-center justify-center gap-3 text-lg">
                            <ion-icon name="cart-outline" class="text-2xl"></ion-icon>
                            Tambah ke Keranjang
                        </button>
                    </form>
                    @endif
                    
                    @if(Auth::check() && Auth::id() !== $product->user_id)
                        <form action="{{ route('chat.start', $product->product_ID) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-white border-2 border-crave-teal text-crave-teal hover:bg-crave-teal hover:text-white font-bold py-3.5 rounded-2xl transition-colors shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                <ion-icon name="chatbubble-ellipses-outline" class="text-xl"></ion-icon>
                                Hubungi Penjual
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
