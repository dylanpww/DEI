@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-8 min-h-[80vh] flex flex-col relative">
    
    <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-6">
        <div class="flex items-center gap-3">
            <ion-icon name="cart" class="text-3xl text-crave-teal"></ion-icon>
            <h1 class="font-extrabold text-2xl text-crave-teal">My Cart</h1>
        </div>
        
        @if(isset($cartItems) && $cartItems->count() > 0)
        <a href="{{ auth()->check() ? route('addresses.index') : route('login') }}" class="inline-flex items-center gap-2 rounded-full bg-crave-lime/20 px-4 py-2 text-sm font-bold text-crave-darkgreen transition-all hover:bg-crave-lime hover:text-white shadow-sm transform hover:-translate-y-0.5">
            <ion-icon name="location-outline" class="text-lg"></ion-icon>
            <span class="hidden sm:inline">Delivery Address</span>
            <span class="sm:hidden">Address</span>
        </a>
        @endif
    </div>

    @if(isset($cartItems) && $cartItems->count() > 0)
        <div class="flex-1 overflow-y-auto space-y-5 pr-2">
            @foreach($cartItems as $item)
            <div class="flex items-center justify-between bg-gray-50/50 p-4 rounded-2xl border border-gray-100 hover:border-crave-lime/50 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 bg-crave-beige rounded-xl flex items-center justify-center p-2 shadow-inner">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="object-contain w-full h-full drop-shadow-sm">
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="font-bold text-base text-crave-teal">{{ $item->product->name }}</h3>
                        <p class="text-xs text-gray-500 mb-1">{{ $item->unit }}</p>
                        <p class="font-extrabold text-sm text-crave-darkgreen">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3 bg-white p-1 rounded-full border border-gray-200 shadow-sm">
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-crave-teal transition-colors">
                        <ion-icon name="remove"></ion-icon>
                    </button>
                    <span class="font-bold text-crave-teal w-4 text-center">{{ $item->quantity }}</span>
                    <button class="w-8 h-8 rounded-full flex items-center justify-center bg-crave-lime text-white hover:bg-crave-green transition-colors">
                        <ion-icon name="add"></ion-icon>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="space-y-3 mb-6 px-2">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal</span>
                    <span class="font-medium text-gray-800">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Delivery Fee</span>
                    <span class="font-medium text-gray-800">Rp 10.000</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-dashed border-gray-200 mt-3">
                    <span class="font-bold text-gray-800 text-base">Total Estimate</span>
                    <span class="font-extrabold text-xl text-crave-darkgreen">Rp {{ number_format($totalPrice + 10000, 0, ',', '.') }}</span>
                </div>
            </div>

            <button class="w-full bg-crave-green hover:bg-crave-darkgreen text-white font-bold text-lg py-4 rounded-2xl shadow-md transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                Go to Checkout <ion-icon name="arrow-forward-outline"></ion-icon>
            </button>
        </div>

    @else
        <div class="flex-1 flex flex-col items-center justify-center text-center p-10">
            <div class="w-48 h-48 bg-crave-beige/50 rounded-full flex items-center justify-center mb-6">
                <ion-icon name="basket-outline" class="text-7xl text-crave-orange/50"></ion-icon>
            </div>
            <h2 class="text-2xl font-bold text-crave-teal mb-2">Your cart is empty</h2>
            <p class="text-gray-500 max-w-xs mb-8">Looks like you haven't added anything to your cart yet. Let's find some delicious surplus food!</p>
            
            <a href="{{ route('home') }}" class="bg-crave-orange hover:bg-crave-brown text-white font-bold py-3 px-8 rounded-full transition-all shadow-md transform hover:-translate-y-0.5 flex items-center gap-2">
                <ion-icon name="search-outline"></ion-icon> Start Exploring
            </a>
        </div>
    @endif

</div>
@endsection