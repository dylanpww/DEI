@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-shadow duration-300 p-8 h-full min-h-[80vh] border border-gray-100 relative overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-crave-lime/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-crave-teal/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 relative z-10">
            <div>
                <h1 class="font-black text-4xl text-crave-teal drop-shadow-sm mb-2">Selamat datang kembali! 🌿</h1>
                <p class="text-gray-500 font-medium text-lg">Siap menyelamatkan makanan hari ini?</p>
            </div>
            @if(isset($foodWasteSaved))
            <div class="bg-gradient-to-r from-crave-lime to-crave-green px-8 py-5 rounded-3xl flex items-center gap-5 shadow-[0_10px_30px_rgba(195,221,42,0.4)] transform hover:-translate-y-1 transition-transform border border-crave-lime/50">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <ion-icon name="earth" class="text-3xl text-crave-darkgreen drop-shadow-md"></ion-icon>
                </div>
                <div>
                    <p class="text-crave-darkgreen/80 font-bold text-sm tracking-wide">Food Waste Diselamatkan</p>
                    <p class="text-2xl font-black text-crave-teal drop-shadow-sm">{{ $foodWasteSaved }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-gradient-to-r from-crave-lime/20 to-crave-green/10 border border-crave-lime/30 p-6 rounded-2xl mb-12 text-crave-darkgreen font-bold flex items-center gap-4 shadow-sm relative z-10">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                <ion-icon name="checkmark-circle" class="text-2xl text-crave-green"></ion-icon>
            </div>
            Anda berhasil masuk dengan aman.
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
            @if (auth()->check() && (Auth::user()->role === 'seller' || Auth::user()->role === 'admin'))
            <a href="{{ route('products.index') }}"
                class="bg-white hover:bg-gradient-to-br hover:from-white hover:to-crave-beige/30 p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all transform hover:-translate-y-2 flex items-center justify-between group">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-crave-orange/10 rounded-2xl flex items-center justify-center text-3xl text-crave-orange group-hover:scale-110 transition-transform">
                        <ion-icon name="storefront"></ion-icon>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-crave-teal mb-1 group-hover:text-crave-orange transition-colors">Toko Saya</h3>
                        <p class="text-sm font-medium text-gray-500">Kelola daftar makanan sisa Anda</p>
                    </div>
                </div>
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center group-hover:bg-crave-orange/20 transition-colors">
                    <ion-icon name="arrow-forward" class="text-2xl text-gray-400 group-hover:text-crave-orange transition-colors"></ion-icon>
                </div>
            </a>
            @endif

            <a href="/explore"
                class="bg-white hover:bg-gradient-to-br hover:from-white hover:to-crave-lime/20 p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all transform hover:-translate-y-2 flex items-center justify-between group">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-crave-lime/20 rounded-2xl flex items-center justify-center text-3xl text-crave-darkgreen group-hover:scale-110 transition-transform">
                        <ion-icon name="search"></ion-icon>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-crave-teal mb-1 group-hover:text-crave-darkgreen transition-colors">Jelajahi Penawaran</h3>
                        <p class="text-sm font-medium text-gray-500">Temukan makanan yang bisa diselamatkan</p>
                    </div>
                </div>
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center group-hover:bg-crave-lime/30 transition-colors">
                    <ion-icon name="arrow-forward" class="text-2xl text-gray-400 group-hover:text-crave-darkgreen transition-colors"></ion-icon>
                </div>
            </a>
        </div>
    </div>
@endsection
