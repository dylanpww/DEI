@extends('layouts.app')

@section('content')
<div class="bg-white rounded-3xl shadow-sm p-8 h-full min-h-[80vh] border border-gray-100">
    <h1 class="font-bold text-3xl text-crave-teal mb-2">Welcome back! 🌿</h1>
    <p class="text-gray-500 mb-8">Ready to save some food today?</p>

    <div class="bg-crave-lime/20 border border-crave-lime p-6 rounded-2xl mb-8 text-crave-teal font-medium flex items-center gap-3">
        <ion-icon name="checkmark-circle" class="text-2xl text-crave-green"></ion-icon>
        You're logged in securely.
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('products.index') }}" class="bg-gray-50 hover:bg-crave-beige p-6 rounded-2xl border border-gray-100 transition-colors flex items-center justify-between group">
            <div>
                <h3 class="text-xl font-bold text-crave-teal mb-1">My Products</h3>
                <p class="text-sm text-gray-500">Manage your surplus food listings</p>
            </div>
            <ion-icon name="arrow-forward-circle" class="text-4xl text-crave-orange group-hover:text-crave-brown transition-colors"></ion-icon>
        </a>

        <a href="/explore" class="bg-gray-50 hover:bg-crave-beige p-6 rounded-2xl border border-gray-100 transition-colors flex items-center justify-between group">
            <div>
                <h3 class="text-xl font-bold text-crave-teal mb-1">Explore Deals</h3>
                <p class="text-sm text-gray-500">Discover rescued food categories</p>
            </div>
            <ion-icon name="arrow-forward-circle" class="text-4xl text-crave-lime group-hover:text-crave-green transition-colors"></ion-icon>
        </a>
    </div>
</div>
@endsection