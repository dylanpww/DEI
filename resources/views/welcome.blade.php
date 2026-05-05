@extends('layouts.app')

@section('content')
<div class="bg-crave-beige min-h-[85vh] rounded-3xl p-8 md:p-16 flex flex-col items-center justify-center text-center relative overflow-hidden shadow-sm">
    <div class="absolute top-10 left-10 text-crave-lightyellow opacity-50 text-9xl transform -rotate-12">
        <ion-icon name="leaf"></ion-icon>
    </div>
    <div class="absolute bottom-10 right-10 text-crave-lime opacity-30 text-9xl transform rotate-12">
        <ion-icon name="fast-food"></ion-icon>
    </div>

    <div class="z-10 flex flex-col items-center">
        <div class="flex items-center text-crave-teal font-extrabold text-5xl md:text-6xl mb-8">
            <ion-icon name="leaf" class="mr-3 text-crave-lime"></ion-icon> Crave
        </div>
        
        <h1 class="text-4xl md:text-6xl font-extrabold text-crave-teal mb-6 leading-tight">
            Save Food,<br>
            <span class="text-crave-darkgreen">Save the Planet.</span>
        </h1>
        
        <p class="text-lg md:text-xl text-crave-brown mb-10 max-w-2xl font-medium">
            Join Crave today. Help reduce food waste while enjoying delicious, surplus meals from your favorite local stores at a fraction of the price.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <a href="{{ route('explore') }}" class="bg-white text-crave-teal border-2 border-crave-teal px-10 py-4 rounded-full font-bold hover:bg-gray-50 transition-colors shadow-lg text-lg">
                Explore Now
            </a>

            @if (Route::has('login'))
                @auth
                    @if(Auth::user()->role === 'seller' || Auth::user()->role === 'admin')
                    <a href="{{ route('products.index') }}" class="bg-crave-lime text-crave-teal px-10 py-4 rounded-full font-bold hover:bg-crave-green transition-colors shadow-lg text-lg">
                        My Products
                    </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-crave-teal text-white px-10 py-4 rounded-full font-bold hover:bg-crave-darkgreen transition-colors shadow-lg text-lg">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white text-crave-teal border-2 border-crave-teal px-10 py-4 rounded-full font-bold hover:bg-gray-50 transition-colors shadow-lg text-lg">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</div>
@endsection