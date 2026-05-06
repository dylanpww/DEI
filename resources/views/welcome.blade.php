@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="min-h-[85vh] p-8 md:p-16 flex flex-col lg:flex-row items-center justify-between text-center lg:text-left mb-12 relative z-10">


    <div class="z-10 flex flex-col items-center lg:items-start max-w-2xl">
        <img src="{{ asset('images/logo-text.png') }}" alt="Crave" class="h-16 md:h-20 mb-8 object-contain">
        
        <h1 class="text-4xl md:text-6xl font-extrabold text-crave-teal mb-6 leading-tight">
            Save Food,<br>
            <span class="text-crave-darkgreen">Save the Planet.</span>
        </h1>
        
        <p class="text-lg md:text-xl text-crave-brown mb-10 max-w-xl font-medium">
            Join Crave today. Help reduce food waste while enjoying delicious, surplus meals from your favorite local stores at a fraction of the price.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <a href="{{ route('explore') }}" class="bg-white text-crave-teal border-2 border-crave-teal px-10 py-4 rounded-full font-bold hover:bg-gray-50 transition-colors shadow-lg text-lg text-center">
                Explore Now
            </a>

            @if (Route::has('login'))
                @auth
                    @if(Auth::user()->role === 'seller' || Auth::user()->role === 'admin')
                    <a href="{{ route('products.index') }}" class="bg-crave-lime text-crave-teal px-10 py-4 rounded-full font-bold hover:bg-crave-green transition-colors shadow-lg text-lg text-center">
                        My Products
                    </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-crave-teal text-white px-10 py-4 rounded-full font-bold hover:bg-crave-darkgreen transition-colors shadow-lg text-lg text-center">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white text-crave-teal border-2 border-crave-teal px-10 py-4 rounded-full font-bold hover:bg-gray-50 transition-colors shadow-lg text-lg text-center">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
    
    <!-- Mascot 1 -->
    <div class="z-10 mt-12 lg:mt-0 w-full lg:w-1/2 flex justify-center lg:justify-end">
        <img src="{{ asset('images/mascot-1.png') }}" alt="Crave Mascot" class="max-w-xs md:max-w-md lg:max-w-lg object-contain drop-shadow-2xl animate-bounce-slow">
    </div>
</div>

<!-- How it Works Section -->
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 mb-12">
    <div class="bg-crave-lime rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center gap-12 relative overflow-hidden shadow-lg">
        <div class="w-full md:w-1/2 flex justify-center relative z-10">
            <img src="{{ asset('images/mascot-2.png') }}" alt="Download App" class="max-w-xs md:max-w-md object-contain drop-shadow-xl transform -rotate-3 hover:rotate-0 transition-transform duration-500">
        </div>
        <div class="w-full md:w-1/2 flex flex-col items-center md:items-start text-center md:text-left z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold text-crave-teal mb-6">Shop anywhere with Crave!</h2>
            <p class="text-lg text-crave-teal font-medium mb-8">
                Browse surplus food, place your order, and pick it up at the store. It's that simple! Rescue food and save your wallet today.
            </p>
            <button class="bg-crave-teal text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-crave-darkgreen transition-colors shadow-md flex items-center gap-2">
                <ion-icon name="logo-apple"></ion-icon> Download App
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 4s ease-in-out infinite;
    }
</style>


@endsection
