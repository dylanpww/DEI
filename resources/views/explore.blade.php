@extends('layouts.app')

@section('content')
<div class="bg-white rounded-3xl shadow-sm p-8 h-full min-h-[80vh]">
    
    <!-- Header & Search (Side by side on Desktop) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <h1 class="font-bold text-3xl text-crave-teal">Explore Categories</h1>
        
        <!-- Search Bar -->
        <div class="relative w-full md:w-96">
            <ion-icon name="search" class="absolute left-4 top-4 text-gray-400 text-xl"></ion-icon>
            <input type="text" placeholder="Search for surplus food, categories, or stores..." class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-4 pl-12 pr-4 outline-none text-md focus:ring-2 focus:ring-crave-lime focus:border-transparent transition-all shadow-inner">
        </div>
    </div>

    <!-- Responsive Categories Grid -->
    <!-- On mobile: 2 columns. On tablet: 3 columns. On laptop: 4 columns. On large desktop: 6 columns. -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
        
        <a href="#" class="bg-crave-lime rounded-3xl p-6 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300">
            <div class="h-20 w-20 mb-4 bg-white rounded-full bg-opacity-30 flex items-center justify-center text-4xl"><ion-icon name="nutrition-outline" class="text-crave-teal"></ion-icon></div>
            <span class="font-bold text-lg text-crave-teal text-center leading-tight">Fresh Fruits<br>& Vegetable</span>
        </a>

        <a href="#" class="bg-crave-orange rounded-3xl p-6 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300">
            <div class="h-20 w-20 mb-4 bg-white rounded-full bg-opacity-30 flex items-center justify-center text-4xl"><ion-icon name="water-outline" class="text-white"></ion-icon></div>
            <span class="font-bold text-lg text-white text-center leading-tight">Cooking Oil<br>& Ghee</span>
        </a>

        <a href="#" class="bg-crave-pink rounded-3xl p-6 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300">
            <div class="h-20 w-20 mb-4 bg-white rounded-full bg-opacity-30 flex items-center justify-center text-4xl"><ion-icon name="fish-outline" class="text-white"></ion-icon></div>
            <span class="font-bold text-lg text-white text-center leading-tight">Meat<br>& Fish</span>
        </a>

        <a href="#" class="bg-crave-lightyellow rounded-3xl p-6 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300">
            <div class="h-20 w-20 mb-4 bg-white rounded-full bg-opacity-50 flex items-center justify-center text-4xl"><ion-icon name="pizza-outline" class="text-crave-brown"></ion-icon></div>
            <span class="font-bold text-lg text-crave-brown text-center leading-tight">Bakery<br>& Snacks</span>
        </a>

        <a href="#" class="bg-crave-beige rounded-3xl p-6 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300">
            <div class="h-20 w-20 mb-4 bg-white rounded-full bg-opacity-50 flex items-center justify-center text-4xl"><ion-icon name="egg-outline" class="text-crave-brown"></ion-icon></div>
            <span class="font-bold text-lg text-crave-brown text-center leading-tight">Dairy<br>& Eggs</span>
        </a>

        <a href="#" class="bg-crave-lightpink rounded-3xl p-6 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300">
            <div class="h-20 w-20 mb-4 bg-white rounded-full bg-opacity-30 flex items-center justify-center text-4xl"><ion-icon name="cafe-outline" class="text-white"></ion-icon></div>
            <span class="font-bold text-lg text-white text-center leading-tight">Beverages</span>
        </a>

    </div>
</div>
@endsection