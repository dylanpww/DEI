@extends('layouts.app')

@section('content')
<div class="bg-white rounded-3xl shadow-sm p-8 h-full min-h-[80vh]">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div class="flex items-center gap-4 flex-wrap">
            <h1 class="font-bold text-3xl text-crave-teal">Explore Categories</h1>

            @if(auth()->check() && (Auth::user()->role === 'vendor' || Auth::user()->role === 'admin'))
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-full bg-crave-lime px-5 py-3 text-sm font-bold text-crave-teal shadow-sm transition-colors hover:bg-crave-green">
                <ion-icon name="pricetag-outline"></ion-icon>
                Products
            </a>
            @endif
        </div>
        
        <div class="relative w-full md:w-96">
            <ion-icon name="search" class="absolute left-4 top-4 text-gray-400 text-xl"></ion-icon>
            <input type="text" placeholder="Search for surplus food, categories, or stores..." class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-4 pl-12 pr-4 outline-none text-md focus:ring-2 focus:ring-crave-lime focus:border-transparent transition-all shadow-inner">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl mx-auto">
        
        @foreach($categories as $category)
        <a href="{{ route('products.by-category', $category->category_id) }}" class="rounded-3xl p-8 flex flex-col items-center justify-center aspect-square shadow-sm transform hover:-translate-y-2 hover:shadow-lg transition-all duration-300 {{ $category->name === 'Makanan' ? 'bg-crave-lime' : 'bg-crave-lightpink' }}">
            <div class="h-24 w-24 mb-5 bg-white rounded-full bg-opacity-30 flex items-center justify-center text-5xl">
                @if($category->name === 'Makanan')
                    <ion-icon name="nutrition-outline" class="text-crave-teal"></ion-icon>
                @else
                    <ion-icon name="cafe-outline" class="text-white"></ion-icon>
                @endif
            </div>
            <span class="font-bold text-2xl {{ $category->name === 'Makanan' ? 'text-crave-teal' : 'text-white' }} text-center leading-tight">{{ $category->name }}</span>
            <p class="mt-3 text-sm {{ $category->name === 'Makanan' ? 'text-crave-teal' : 'text-white' }} text-center opacity-80">{{ $category->description }}</p>
        </a>
        @endforeach

    </div>
</div>
@endsection