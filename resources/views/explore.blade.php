@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-3xl shadow-sm p-8 h-full min-h-[80vh]">

        <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-gray-400 font-bold text-sm uppercase tracking-widest mb-1">Selamat datang,
                    {{ auth()->user()->username ?? 'Tamu' }}!</h2>
                <h1 class="font-black text-4xl text-crave-teal">
                    @if (auth()->check() && auth()->user()->role === 'seller')
                        Dashboard Toko Anda Siap 🌿
                    @else
                        Temukan Penawaran Segar 🌿
                    @endif
                </h1>
            </div>
            
            @if(isset($foodWasteSaved))
            <div class="bg-crave-lime px-6 py-4 rounded-2xl flex items-center gap-4 shadow-sm">
                <ion-icon name="earth" class="text-4xl text-crave-teal"></ion-icon>
                <div>
                    <p class="text-crave-teal font-bold text-sm">Food Waste Diselamatkan</p>
                    <p class="text-2xl font-black text-crave-darkgreen">{{ $foodWasteSaved }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div class="flex items-center gap-4 flex-wrap">
                <h1 class="font-bold text-2xl text-crave-teal">Jelajahi Kategori</h1>

                @if (auth()->check() && (Auth::user()->role === 'seller' || Auth::user()->role === 'admin'))
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-crave-teal px-6 py-3 text-sm font-bold text-white shadow-lg transition-all hover:bg-crave-darkgreen hover:scale-105">
                        <ion-icon name="storefront-outline"></ion-icon>
                        Pergi ke Toko Saya
                    </a>
                @endif
            </div>

            <!-- Search removed per request: users navigate via categories -->
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl mx-auto">

            @foreach ($categories as $category)
                <a href="{{ route('products.by-category', $category->category_id) }}"
                    class="rounded-3xl p-8 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300 {{ $category->name === 'Makanan' ? 'bg-crave-lime' : 'bg-crave-lightpink' }}">
                    <div
                        class="h-24 w-24 mb-5 bg-white rounded-full bg-opacity-30 flex items-center justify-center text-5xl">
                        @if ($category->name === 'Makanan')
                            <ion-icon name="nutrition-outline" class="text-crave-teal"></ion-icon>
                        @else
                            <ion-icon name="cafe-outline" class="text-white"></ion-icon>
                        @endif
                    </div>
                    <span
                        class="font-bold text-2xl {{ $category->name === 'Makanan' ? 'text-crave-teal' : 'text-white' }} text-center leading-tight">{{ $category->name }}</span>
                    <p
                        class="mt-3 text-sm {{ $category->name === 'Makanan' ? 'text-crave-teal' : 'text-white' }} text-center opacity-80">
                        {{ $category->description }}</p>
                </a>
            @endforeach

        </div>

        <!-- Recent Products -->
        @if (isset($products) && $products->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-extrabold text-crave-teal mb-6 text-center">Produk Terbaru</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    @foreach ($products as $product)
                        <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow flex flex-col">
                            <div class="h-48 bg-crave-beige flex items-center justify-center overflow-hidden">
                                @php 
                                    $primaryImage = $product->images->first() ? $product->images->first()->image_path : $product->image;
                                    $stored = $primaryImage && file_exists(public_path('storage/' . $primaryImage)); 
                                @endphp
                                @if ($stored)
                                    <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/placeholder.svg') }}" alt="Tidak ada gambar"
                                        class="w-24 h-24 object-contain">
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-bold text-lg text-crave-teal mb-2">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-3">{{ optional($product->category)->name }}</p>

                                <div class="flex items-center justify-between mb-4 mt-auto">
                                    <div>
                                        <p class="text-2xl font-bold text-crave-darkgreen">Rp
                                            {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}
                                        </p>
                                        @if ($product->discount > 0)
                                            <p class="text-xs text-gray-400 line-through">Rp
                                                {{ number_format($product->actualPrice, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-crave-lime text-crave-teal">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>

                                <a href="{{ route('products.show', $product->product_ID) }}"
                                    class="w-full block text-center bg-crave-lime hover:bg-crave-green text-crave-teal font-bold py-2 px-4 rounded-lg transition-colors">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
