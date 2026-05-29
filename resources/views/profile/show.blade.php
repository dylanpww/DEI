@extends('layouts.app')

@section('title', 'Profil Saya - Crave')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    
    <!-- Header Card -->
    <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 overflow-hidden relative group">
        <!-- Background Decor -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-crave-lime/20 rounded-full blur-3xl pointer-events-none group-hover:scale-110 transition-transform duration-700"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-crave-pink/10 rounded-full blur-2xl pointer-events-none group-hover:scale-110 transition-transform duration-700"></div>

        <div class="h-40 bg-gradient-to-r from-crave-teal via-crave-darkgreen to-crave-green relative overflow-hidden">
            <!-- Pattern overlay -->
            <div class="absolute inset-0 bg-[url('{{ asset('images/pattern-dark.png') }}')] opacity-20 bg-cover bg-center mix-blend-overlay"></div>
        </div>
        
        <div class="px-8 md:px-12 pb-10 relative z-10">
            <div class="relative flex flex-col md:flex-row justify-between items-start md:items-end -mt-16 md:-mt-20 mb-8 gap-6">
                <div class="flex flex-col md:flex-row items-start md:items-end gap-6">
                    <div class="w-32 h-32 md:w-40 md:h-40 bg-white/80 backdrop-blur-md rounded-3xl p-3 shadow-2xl border border-white/50 transform group-hover:scale-105 transition-transform duration-500">
                        <div class="w-full h-full bg-gradient-to-br from-crave-beige to-white rounded-2xl flex items-center justify-center text-6xl text-crave-teal shadow-inner border border-gray-100">
                            <ion-icon name="person"></ion-icon>
                        </div>
                    </div>
                    <div class="pb-2">
                        <h1 class="text-4xl font-black text-gray-900 drop-shadow-sm mb-1">{{ auth()->user()->username ?? 'Pengguna' }}</h1>
                        <p class="text-crave-teal font-bold uppercase tracking-widest text-sm bg-crave-lime/20 px-3 py-1 rounded-full border border-crave-lime/30 w-fit">
                            Akun {{ auth()->user()->role === 'seller' ? 'Penjual' : (auth()->user()->role === 'admin' ? 'Admin' : 'Pembeli') }}
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3 pb-2 w-full md:w-auto">
                    <a href="{{ route('profile.edit') }}" class="flex-1 md:flex-none bg-white border border-gray-200 hover:border-crave-teal hover:text-crave-teal text-gray-700 font-bold py-3 px-6 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                        <ion-icon name="settings-outline" class="text-xl"></ion-icon> <span class="hidden md:inline">Pengaturan</span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="m-0 flex-1 md:flex-none">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 hover:bg-red-500 border border-red-100 hover:border-red-500 text-red-600 hover:text-white font-bold py-3 px-6 rounded-2xl shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                            <ion-icon name="log-out-outline" class="text-xl"></ion-icon> <span class="hidden md:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 bg-gray-50/50 rounded-[2rem] p-6 md:p-8 border border-gray-100">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100/50 transform hover:-translate-y-1 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-full bg-crave-lime/20 flex items-center justify-center text-crave-darkgreen text-xl mb-3">
                        <ion-icon name="leaf"></ion-icon>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Makanan Diselamatkan</p>
                    <p class="text-3xl font-black text-crave-green drop-shadow-sm">{{ $stats['food_saved_kg'] ?? 0 }} <span class="text-lg font-bold text-gray-400">kg</span></p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100/50 transform hover:-translate-y-1 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-full bg-crave-lime/20 flex items-center justify-center text-crave-darkgreen text-xl mb-3">
                        <ion-icon name="wallet"></ion-icon>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">
                        {{ isset($stats['is_seller']) && $stats['is_seller'] ? 'Uang Didapatkan' : 'Uang Dihemat' }}
                    </p>
                    <p class="text-2xl font-black text-crave-green drop-shadow-sm">Rp {{ number_format($stats['money_saved'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100/50 transform hover:-translate-y-1 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-full bg-crave-teal/10 flex items-center justify-center text-crave-teal text-xl mb-3">
                        <ion-icon name="receipt"></ion-icon>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pesanan</p>
                    <p class="text-3xl font-black text-crave-teal">{{ $stats['total_orders'] ?? 0 }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100/50 transform hover:-translate-y-1 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-full bg-crave-teal/10 flex items-center justify-center text-crave-teal text-xl mb-3">
                        <ion-icon name="star"></ion-icon>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">
                        {{ isset($stats['is_seller']) && $stats['is_seller'] ? 'Ulasan Diterima' : 'Ulasan Diberikan' }}
                    </p>
                    <p class="text-3xl font-black text-crave-teal">{{ $stats['total_reviews'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Left Column: Orders -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8">
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-crave-lime/20 flex items-center justify-center text-crave-darkgreen">
                            <ion-icon name="receipt-outline"></ion-icon>
                        </div>
                        Pesanan Terakhir
                    </h2>
                    <a href="{{ route('my-transactions') }}" class="text-crave-teal hover:text-crave-green hover:underline text-sm font-bold uppercase tracking-wider">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($orders ?? [] as $order)
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-5 rounded-2xl bg-gray-50/50 border border-gray-100 hover:border-crave-lime hover:bg-white hover:shadow-md transition-all group cursor-default">
                            <div class="flex gap-4 items-center mb-3 sm:mb-0">
                                <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-crave-orange text-2xl border border-gray-100 group-hover:scale-110 transition-transform">
                                    <ion-icon name="fast-food"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="font-black text-gray-800 text-lg group-hover:text-crave-teal transition-colors">{{ $order['item'] }}</h3>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $order['id'] }} • {{ date('d M Y', strtotime($order['date'])) }}</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right flex sm:flex-col items-center sm:items-end justify-between sm:justify-center w-full sm:w-auto">
                                <p class="font-black text-crave-darkgreen text-lg">Rp {{ number_format($order['price'], 0, ',', '.') }}</p>
                                <span class="text-xs font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider mt-0 sm:mt-1 {{ strtolower($order['status']) == 'success' || strtolower($order['status']) == 'settlement' ? 'bg-crave-lime/20 text-crave-darkgreen border border-crave-lime/30' : 'bg-gray-200/50 text-gray-600 border border-gray-200' }}">
                                    {{ $order['status'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                            <div class="text-gray-300 text-5xl mb-3"><ion-icon name="receipt-outline"></ion-icon></div>
                            <p class="text-gray-500 font-medium">Belum ada pesanan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Reviews -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 p-8 h-full">
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-crave-orange/10 flex items-center justify-center text-crave-orange">
                            <ion-icon name="star-half-outline"></ion-icon>
                        </div>
                        {{ isset($stats['is_seller']) && $stats['is_seller'] ? 'Ulasan Produk' : 'Ulasan Saya' }}
                    </h2>
                </div>
                
                <div class="space-y-5">
                    @forelse($reviews ?? [] as $review)
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 hover:border-crave-orange/30 hover:bg-white hover:shadow-md transition-all">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-black text-crave-teal text-lg">{{ $review['seller'] }}</h3>
                                <div class="flex text-crave-orange text-sm bg-crave-orange/10 px-2 py-1 rounded-lg border border-crave-orange/20">
                                    @for($i = 0; $i < $review['rating']; $i++)
                                        <ion-icon name="star"></ion-icon>
                                    @endfor
                                    @for($i = $review['rating']; $i < 5; $i++)
                                        <ion-icon name="star-outline"></ion-icon>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 font-medium leading-relaxed italic">"{{ $review['comment'] }}"</p>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                            <div class="text-gray-300 text-5xl mb-3"><ion-icon name="star-outline"></ion-icon></div>
                            <p class="text-gray-500 font-medium">Belum ada ulasan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
