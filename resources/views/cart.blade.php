@extends('layouts.app')

@section('content')
<div class="p-5 h-full bg-white flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-center mb-6 border-b pb-4">
        <h1 class="font-bold text-lg text-crave-teal">My Cart</h1>
    </div>

    <!-- Cart Items List -->
    <div class="flex-1 overflow-y-auto space-y-6">
        
        <!-- Cart Item 1 -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-crave-beige rounded-xl flex items-center justify-center p-2">
                    <img src="/images/pepper.png" alt="Bell Pepper Red" class="object-cover">
                </div>
                <div>
                    <h3 class="font-bold text-sm text-crave-teal">Bell Pepper Red</h3>
                    <p class="text-xs text-gray-400">1kg, Price</p>
                    <p class="font-bold text-sm mt-1 text-crave-darkgreen">Rp 15.000</p>
                </div>
            </div>
            <!-- Quantity Adjuster -->
            <div class="flex items-center space-x-3">
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:border-crave-lime hover:text-crave-lime">
                    <ion-icon name="remove"></ion-icon>
                </button>
                <span class="font-semibold text-crave-teal">1</span>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-crave-lime hover:bg-crave-lime hover:text-white transition-colors">
                    <ion-icon name="add"></ion-icon>
                </button>
            </div>
        </div>

        <!-- Cart Item 2 -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-crave-beige rounded-xl flex items-center justify-center p-2">
                    <img src="/images/egg.png" alt="Egg Chicken Red" class="object-cover">
                </div>
                <div>
                    <h3 class="font-bold text-sm text-crave-teal">Egg Chicken Red</h3>
                    <p class="text-xs text-gray-400">4pcs, Price</p>
                    <p class="font-bold text-sm mt-1 text-crave-darkgreen">Rp 12.000</p>
                </div>
            </div>
            <!-- Quantity Adjuster -->
            <div class="flex items-center space-x-3">
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:border-crave-lime hover:text-crave-lime">
                    <ion-icon name="remove"></ion-icon>
                </button>
                <span class="font-semibold text-crave-teal">1</span>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-crave-lime hover:bg-crave-lime hover:text-white transition-colors">
                    <ion-icon name="add"></ion-icon>
                </button>
            </div>
        </div>

    </div>

    <!-- Checkout Button -->
    <div class="mt-4 pt-4 bg-white">
        <button class="w-full bg-crave-lime text-white font-bold text-lg py-4 rounded-2xl shadow-lg hover:bg-crave-green transition-colors flex justify-center items-center">
            Go to Checkout
        </button>
    </div>
</div>
@endsection