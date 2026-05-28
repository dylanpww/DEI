@extends('layouts.app')

@section('title', 'Profil Saya - Crave')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Header Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-crave-lime to-crave-green"></div>
        <div class="px-8 pb-8">
            <div class="relative flex justify-between items-end -mt-12 mb-6">
                <div class="flex items-end gap-6">
                    <div class="w-24 h-24 bg-white rounded-full p-2 shadow-lg">
                        <div class="w-full h-full bg-crave-beige rounded-full flex items-center justify-center text-4xl text-crave-orange">
                            <ion-icon name="person"></ion-icon>
                        </div>
                    </div>
                    <div class="pb-2">
                        <h1 class="text-3xl font-extrabold text-crave-teal">{{ auth()->user()->username ?? 'Pengguna' }}</h1>
                        <p class="text-gray-500 capitalize">Akun {{ auth()->user()->role === 'seller' ? 'Penjual' : (auth()->user()->role === 'admin' ? 'Admin' : 'Pembeli') }}</p>
                    </div>
                </div>
                
                <div class="flex gap-3 pb-2">
                    <a href="{{ route('profile.edit') }}" class="bg-gray-100 hover:bg-gray-200 text-crave-teal font-semibold py-2 px-6 rounded-full transition-colors flex items-center gap-2">
                        <ion-icon name="settings-outline"></ion-icon> Pengaturan
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="bg-crave-pink hover:bg-crave-pink/90 text-white font-semibold py-2 px-6 rounded-full shadow-sm transition-colors flex items-center gap-2">
                            <ion-icon name="log-out-outline"></ion-icon> Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 rounded-2xl p-6">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Makanan Diselamatkan</p>
                    <p class="text-2xl font-black text-crave-green">{{ $stats['food_saved_kg'] ?? 0 }} kg</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Uang Dihemat</p>
                    <p class="text-2xl font-black text-crave-green">Rp {{ number_format($stats['money_saved'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
                    <p class="text-2xl font-black text-crave-teal">{{ count($orders ?? []) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Ulasan Diberikan</p>
                    <p class="text-2xl font-black text-crave-teal">{{ count($reviews ?? []) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Left Column: Orders -->
        <div class="space-y-8">
            <!-- Order History -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-crave-teal flex items-center gap-2">
                        <ion-icon name="receipt-outline"></ion-icon> Riwayat Pesanan (5 Terakhir)
                    </h2>
                    <a href="{{ route('my-transactions') }}" class="text-crave-green hover:underline text-sm font-medium">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($orders ?? [] as $order)
                        <div class="flex justify-between items-center p-4 rounded-2xl border border-gray-100 hover:border-crave-lime transition-colors group">
                            <div class="flex gap-4 items-center">
                                <div class="w-12 h-12 bg-crave-beige rounded-xl flex items-center justify-center text-crave-orange text-xl">
                                    <ion-icon name="fast-food"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="font-bold text-crave-teal">{{ $order['item'] }}</h3>
                                    <p class="text-xs text-gray-500">{{ $order['id'] }} • {{ date('d M Y', strtotime($order['date'])) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-crave-green">Rp {{ number_format($order['price'], 0, ',', '.') }}</p>
                                <span class="text-xs font-semibold px-2 py-1 rounded-md {{ strtolower($order['status']) == 'success' || strtolower($order['status']) == 'settlement' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $order['status'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada pesanan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Reviews -->
        <div class="space-y-8">
            <!-- Reviews -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 h-full">
                <h2 class="text-xl font-bold text-crave-teal flex items-center gap-2 mb-6">
                    <ion-icon name="star-half-outline"></ion-icon> Ulasan Saya
                </h2>
                
                <div class="space-y-4">
                    @forelse($reviews ?? [] as $review)
                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-crave-teal">{{ $review['seller'] }}</h3>
                                <div class="flex text-crave-orange text-sm">
                                    @for($i = 0; $i < $review['rating']; $i++)
                                        <ion-icon name="star"></ion-icon>
                                    @endfor
                                    @for($i = $review['rating']; $i < 5; $i++)
                                        <ion-icon name="star-outline"></ion-icon>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm">"{{ $review['comment'] }}"</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada ulasan.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
