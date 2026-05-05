@extends('layouts.app')

@section('title', 'My Profile - Crave')

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
                        <h1 class="text-3xl font-extrabold text-crave-teal">{{ auth()->user()->username ?? 'User' }}</h1>
                        <p class="text-gray-500 capitalize">{{ auth()->user()->role ?? 'User' }} Account</p>
                    </div>
                </div>
                
                <div class="flex gap-3 pb-2">
                    <a href="{{ route('profile.edit') }}" class="bg-gray-100 hover:bg-gray-200 text-crave-teal font-semibold py-2 px-6 rounded-full transition-colors flex items-center gap-2">
                        <ion-icon name="settings-outline"></ion-icon> Settings
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="bg-crave-pink hover:bg-crave-pink/90 text-white font-semibold py-2 px-6 rounded-full shadow-sm transition-colors flex items-center gap-2">
                            <ion-icon name="log-out-outline"></ion-icon> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 rounded-2xl p-6">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Food Saved</p>
                    <p class="text-2xl font-black text-crave-green">{{ $stats['food_saved_kg'] ?? 0 }} kg</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Money Saved</p>
                    <p class="text-2xl font-black text-crave-green">${{ number_format($stats['money_saved'] ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Orders</p>
                    <p class="text-2xl font-black text-crave-teal">{{ count($orders ?? []) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Reviews Given</p>
                    <p class="text-2xl font-black text-crave-teal">{{ count($reviews ?? []) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left Column: Orders & Reviews -->
        <div class="md:col-span-2 space-y-8">
            
            <!-- Order History -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-crave-teal flex items-center gap-2">
                        <ion-icon name="receipt-outline"></ion-icon> Order History
                    </h2>
                    <a href="#" class="text-crave-green hover:underline text-sm font-medium">View All</a>
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
                                    <p class="text-xs text-gray-500">Order {{ $order['id'] }} • {{ date('M d, Y', strtotime($order['date'])) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-crave-green">${{ number_format($order['price'], 2) }}</p>
                                <span class="text-xs font-semibold px-2 py-1 rounded-md {{ $order['status'] == 'Completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $order['status'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No orders yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Reviews -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold text-crave-teal flex items-center gap-2 mb-6">
                    <ion-icon name="star-half-outline"></ion-icon> My Reviews
                </h2>
                
                <div class="space-y-4">
                    @forelse($reviews ?? [] as $review)
                        <div class="p-4 rounded-2xl bg-gray-50">
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
                        <p class="text-gray-500 text-sm">No reviews yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Column: Favorites & Promos -->
        <div class="space-y-8">
            
            <!-- Favorites -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold text-crave-teal flex items-center gap-2 mb-6">
                    <ion-icon name="heart-outline"></ion-icon> Favorite Sellers
                </h2>
                
                <div class="space-y-4">
                    @forelse($favorites ?? [] as $favorite)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-crave-lime/20 text-crave-darkgreen rounded-full flex items-center justify-center">
                                <ion-icon name="storefront"></ion-icon>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-crave-teal">{{ $favorite['name'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $favorite['type'] }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No favorites yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Eco Badge Promo -->
            <div class="bg-gradient-to-br from-crave-teal to-crave-darkgreen rounded-3xl p-8 text-white text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    🌍
                </div>
                <h3 class="font-bold text-lg mb-2">Eco Warrior</h3>
                <p class="text-sm text-white/80 mb-4">You're doing great! Keep saving food to unlock the next tier.</p>
                <div class="w-full bg-black/20 rounded-full h-2 mb-2">
                    <div class="bg-crave-lime h-2 rounded-full" style="width: 60%"></div>
                </div>
                <p class="text-xs text-white/60">60% to Level 2</p>
            </div>

        </div>
    </div>
</div>
@endsection
