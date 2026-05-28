@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-3xl shadow-sm p-8 h-full min-h-[80vh] border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <div>
                <h1 class="font-bold text-3xl text-crave-teal mb-2">Selamat datang kembali! 🌿</h1>
                <p class="text-gray-500">Siap menyelamatkan makanan hari ini?</p>
            </div>
            @if(isset($foodWasteSaved))
            <div class="bg-crave-lime px-6 py-4 rounded-2xl flex items-center gap-4 shadow-sm">
                <ion-icon name="earth" class="text-4xl text-crave-teal"></ion-icon>
                <div>
                    <p class="text-crave-teal font-bold text-sm">Food Waste Diselamatkan</p>
                    <p class="text-2xl font-black text-crave-darkgreen">{{ $foodWasteSaved }}</p>
                </div>
            </div>
            @endif
        </div>

        <div
            class="bg-crave-lime/20 border border-crave-lime p-6 rounded-2xl mb-8 text-crave-teal font-medium flex items-center gap-3">
            <ion-icon name="checkmark-circle" class="text-2xl text-crave-green"></ion-icon>
            Anda berhasil masuk dengan aman.
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if (auth()->check() && (Auth::user()->role === 'seller' || Auth::user()->role === 'admin'))
            <a href="{{ route('products.index') }}"
                class="bg-gray-50 hover:bg-crave-beige p-6 rounded-2xl border border-gray-100 transition-colors flex items-center justify-between group">
                <div>
                    <h3 class="text-xl font-bold text-crave-teal mb-1">Produk Saya</h3>
                    <p class="text-sm text-gray-500">Kelola daftar makanan sisa Anda</p>
                </div>
                <ion-icon name="arrow-forward-circle"
                    class="text-4xl text-crave-orange group-hover:text-crave-brown transition-colors"></ion-icon>
            </a>
            @endif

            <a href="/explore"
                class="bg-gray-50 hover:bg-crave-beige p-6 rounded-2xl border border-gray-100 transition-colors flex items-center justify-between group">
                <div>
                    <h3 class="text-xl font-bold text-crave-teal mb-1">Jelajahi Penawaran</h3>
                    <p class="text-sm text-gray-500">Temukan makanan yang bisa diselamatkan</p>
                </div>
                <ion-icon name="arrow-forward-circle"
                    class="text-4xl text-crave-lime group-hover:text-crave-green transition-colors"></ion-icon>
            </a>
        </div>
    </div>
@endsection
