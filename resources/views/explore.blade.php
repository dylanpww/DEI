@extends('layouts.app')

@section('content')
    <div class="space-y-12 pb-20">
        
        <!-- Massive Promo Carousel (Alpine.js) -->
        <div x-data="{
                activeSlide: 0,
                slides: [
                    { id: 1, title: 'TODAY\'S DEALS', subtitle: 'Save Food, Save Money', image: '{{ asset('images/mascot-1.png') }}', discount: '50% OFF', color: 'from-crave-teal to-crave-darkgreen' },
                    { id: 2, title: 'BAKERY SURPLUS', subtitle: 'Fresh pastries for half the price', image: '{{ asset('images/mascot-2.png') }}', discount: 'Beli 1 Gratis 1', color: 'from-crave-orange to-crave-pink' }
                ],
                next() { this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1 },
                prev() { this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1 }
            }" 
            x-init="setInterval(() => next(), 5000)"
            class="relative w-full h-[400px] md:h-[500px] rounded-[2.5rem] overflow-hidden shadow-2xl group">
            
            <template x-for="(slide, index) in slides" :key="slide.id">
                <div x-show="activeSlide === index"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform scale-105"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-500 absolute inset-0"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute inset-0 w-full h-full flex items-center justify-between px-10 md:px-24 bg-gradient-to-br"
                     :class="slide.color">
                     
                     <div class="z-10 max-w-lg text-white">
                        <span class="inline-block px-4 py-1.5 mb-4 text-sm font-bold bg-white/20 backdrop-blur-md rounded-full border border-white/30" x-text="slide.discount"></span>
                        <h1 class="text-4xl md:text-6xl font-black mb-4 leading-tight tracking-tight drop-shadow-lg" x-text="slide.title"></h1>
                        <p class="text-lg md:text-2xl font-medium text-white/90 drop-shadow-md" x-text="slide.subtitle"></p>
                        <a href="#products" class="inline-block mt-8 bg-crave-lime text-crave-darkgreen hover:bg-white hover:text-crave-teal font-extrabold px-8 py-4 rounded-full transition-all transform hover:scale-105 shadow-xl">Belanja Sekarang</a>
                     </div>
                     
                     <div class="hidden md:block z-10 h-full w-1/2 relative">
                         <img :src="slide.image" class="absolute right-0 bottom-0 max-h-[120%] object-contain drop-shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform hover:scale-105 transition-transform duration-700" alt="Promo Mascot">
                     </div>
                     
                     <!-- Decorative Background Elements -->
                     <div class="absolute inset-0 bg-[url('{{ asset('images/pattern-light.png') }}')] opacity-10 bg-cover bg-center pointer-events-none"></div>
                     <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                </div>
            </template>
            
            <!-- Carousel Controls -->
            <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 shadow-lg">
                <ion-icon name="chevron-back" class="text-2xl"></ion-icon>
            </button>
            <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 shadow-lg">
                <ion-icon name="chevron-forward" class="text-2xl"></ion-icon>
            </button>
            
            <!-- Indicators -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                <template x-for="(slide, index) in slides" :key="slide.id">
                    <button @click="activeSlide = index" class="w-3 h-3 rounded-full transition-all" :class="activeSlide === index ? 'bg-white scale-125' : 'bg-white/50'"></button>
                </template>
            </div>
        </div>

        <!-- Glassmorphism Impact Tracker & Header -->
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 bg-white/60 backdrop-blur-xl p-8 rounded-3xl shadow-sm border border-white">
            <div>
                <h2 class="text-gray-400 font-bold text-sm uppercase tracking-widest mb-1">Selamat datang, {{ auth()->user()->username ?? 'Tamu' }}!</h2>
                <h1 class="font-black text-3xl md:text-4xl text-crave-teal drop-shadow-sm">
                    @if (auth()->check() && auth()->user()->role === 'seller')
                        Dashboard Toko Anda Siap 🌿
                    @else
                        Temukan Penawaran Segar 🌿
                    @endif
                </h1>
            </div>
            
            @if(isset($foodWasteSaved))
            <div class="bg-gradient-to-r from-crave-lime to-crave-green px-8 py-5 rounded-3xl flex items-center gap-5 shadow-[0_10px_30px_rgba(195,221,42,0.4)] transform hover:-translate-y-1 transition-transform border border-crave-lime/50">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <ion-icon name="earth" class="text-4xl text-crave-darkgreen drop-shadow-md"></ion-icon>
                </div>
                <div>
                    <p class="text-crave-darkgreen/80 font-bold text-sm tracking-wide">Food Waste Diselamatkan</p>
                    <p class="text-3xl font-black text-crave-teal drop-shadow-sm">{{ $foodWasteSaved }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Categories -->
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <h1 class="font-black text-3xl text-crave-teal">Kategori</h1>
                @if (auth()->check() && (Auth::user()->role === 'seller' || Auth::user()->role === 'admin'))
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-crave-teal to-crave-darkgreen px-8 py-3.5 text-sm font-bold text-white shadow-xl transition-all hover:scale-105 hover:shadow-crave-teal/30">
                        <ion-icon name="storefront-outline" class="text-xl"></ion-icon>
                        Pergi ke Toko Saya
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl">
                @foreach ($categories as $category)
                    <a href="{{ route('products.by-category', $category->category_id) }}"
                        class="group relative overflow-hidden rounded-[2rem] p-8 flex items-center gap-6 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-white {{ $category->name === 'Makanan' ? 'bg-gradient-to-br from-crave-lime to-crave-green' : 'bg-gradient-to-br from-crave-lightpink to-crave-pink' }}">
                        
                        <!-- Background Glow/Pattern -->
                        <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="relative z-10 w-20 h-20 bg-white/30 backdrop-blur-md rounded-2xl flex items-center justify-center text-5xl shadow-inner group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            @if ($category->name === 'Makanan')
                                <ion-icon name="fast-food-outline" class="text-crave-teal"></ion-icon>
                            @else
                                <ion-icon name="cafe-outline" class="text-white"></ion-icon>
                            @endif
                        </div>
                        <div class="relative z-10">
                            <span class="font-black text-3xl {{ $category->name === 'Makanan' ? 'text-crave-teal' : 'text-white' }} block mb-1 drop-shadow-sm">{{ $category->name }}</span>
                            <p class="text-sm font-medium {{ $category->name === 'Makanan' ? 'text-crave-teal/80' : 'text-white/80' }}">{{ $category->description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Recent Products -->
        @if (isset($products) && $products->count() > 0)
            <div id="products" class="pt-8 space-y-8">
                <h2 class="text-3xl font-black text-crave-teal flex items-center gap-3">
                    Penawaran Terbaru <ion-icon name="flame" class="text-crave-orange"></ion-icon>
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product->product_ID) }}" class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col border border-gray-100 transform hover:-translate-y-2">
                            
                            <!-- Product Image Area -->
                            <div class="h-56 relative bg-crave-beige overflow-hidden">
                                <div class="absolute top-4 left-4 z-10 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-bold text-crave-pink shadow-sm">
                                    {{ optional($product->category)->name }}
                                </div>
                                @if($product->discount > 0)
                                    @php $discountPercentage = round(($product->discount / $product->actualPrice) * 100); @endphp
                                    <div class="absolute top-4 right-4 z-10 bg-crave-orange text-white px-3 py-1.5 rounded-full text-xs font-black shadow-md shadow-crave-orange/30">
                                        -{{ $discountPercentage }}%
                                    </div>
                                @endif
                                
                                @php 
                                    $primaryImage = $product->images->first() ? $product->images->first()->image_path : $product->image;
                                    $stored = $primaryImage && file_exists(public_path('storage/' . $primaryImage)); 
                                @endphp
                                @if ($stored)
                                    <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                                @else
                                    <img src="{{ asset('images/placeholder.svg') }}" alt="Tidak ada gambar"
                                        class="w-32 h-32 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 object-contain opacity-40 group-hover:scale-110 transition-transform duration-700">
                                @endif
                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            
                            <!-- Product Info Area -->
                            <div class="p-6 flex flex-col flex-grow bg-white relative z-10 rounded-t-[2rem] -mt-6">
                                <h3 class="font-black text-xl text-crave-teal mb-4 group-hover:text-crave-green transition-colors">{{ $product->name }}</h3>
                                
                                <div class="flex items-end justify-between mb-6 mt-auto">
                                    <div>
                                        <p class="text-xs text-gray-400 font-semibold mb-1">Harga Diselamatkan</p>
                                        <p class="text-2xl font-black text-crave-darkgreen">Rp {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}</p>
                                        @if ($product->discount > 0)
                                            <p class="text-sm text-gray-400 line-through font-medium">Rp {{ number_format($product->actualPrice, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                    <span class="px-4 py-2 rounded-xl text-xs font-bold bg-crave-lime/20 text-crave-darkgreen border border-crave-lime/30">
                                        Sisa: {{ $product->stock }}
                                    </span>
                                </div>
                                
                                <div class="w-full text-center bg-gray-50 group-hover:bg-gradient-to-r group-hover:from-crave-lime group-hover:to-crave-green text-crave-teal group-hover:text-crave-darkgreen font-black py-4 px-4 rounded-xl transition-all duration-300 shadow-sm group-hover:shadow-md">
                                    Ambil Sekarang
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
