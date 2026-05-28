@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-8 min-h-[80vh] flex flex-col relative">

        <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-6">
            <div class="flex items-center gap-3">
                <ion-icon name="cart" class="text-3xl text-crave-teal"></ion-icon>
                <h1 class="font-extrabold text-2xl text-crave-teal">Keranjang Saya</h1>
            </div>
        </div>

        @if (isset($cartItems) && $cartItems->count() > 0)
            <div
                class="mb-8 bg-gradient-to-r from-crave-lime/10 to-transparent p-6 rounded-3xl border border-crave-lime/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-crave-lime/20 rounded-full blur-2xl"></div>
                
                <div class="flex items-start gap-4 relative z-10">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 shrink-0">
                        <ion-icon name="location" class="text-crave-orange text-2xl"></ion-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-500 text-xs uppercase tracking-wider mb-1">Alamat Pengiriman</h3>
                        @if ($selectedAddress)
                            <p class="text-base font-black text-crave-teal">{{ $selectedAddress->name }} <span
                                    class="text-xs text-gray-400 font-bold ml-1">({{ $selectedAddress->telephoneNumber }})</span>
                            </p>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-1 font-medium">{{ $selectedAddress->completeAddress }}</p>
                        @else
                            <p class="text-sm text-crave-pink font-bold mt-1">Belum ada alamat pengiriman yang diatur.</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('addresses.index') }}"
                    class="shrink-0 relative z-10 inline-flex items-center gap-2 text-crave-darkgreen hover:text-white font-bold text-sm bg-white hover:bg-crave-darkgreen border border-gray-200 hover:border-crave-darkgreen px-6 py-3 rounded-2xl shadow-sm hover:shadow-lg transition-all">
                    {{ $selectedAddress ? 'Ubah Alamat' : 'Tambah Alamat' }}
                </a>
            </div>

            <div class="flex-1 overflow-y-auto space-y-4 pr-2 mb-8 no-scrollbar">
                @foreach ($cartItems as $item)
                    <div
                        class="group flex flex-col sm:flex-row items-center justify-between bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md hover:border-crave-lime transition-all">
                        <div class="flex items-center space-x-5 w-full sm:w-auto mb-4 sm:mb-0">
                            <div
                                class="w-24 h-24 bg-gray-50 rounded-2xl flex items-center justify-center p-3 shadow-inner group-hover:bg-crave-beige transition-colors">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                    class="object-contain w-full h-full transform group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="flex flex-col justify-center">
                                <h3 class="font-black text-lg text-crave-teal group-hover:text-crave-green transition-colors">{{ $item->name }}</h3>
                                <p class="text-xs text-gray-400 font-bold tracking-widest uppercase mb-2">{{ $item->unit }}</p>
                                <p class="font-black text-xl text-crave-darkgreen">Rp
                                    {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 bg-gray-50 p-1.5 rounded-2xl border border-gray-100 shadow-inner w-full sm:w-auto justify-center">
                            <form action="{{ route('cart.decrease') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button type="submit"
                                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-white text-gray-500 hover:bg-gray-200 hover:text-crave-teal shadow-sm transition-all border border-gray-200">
                                    <ion-icon name="remove" class="text-xl"></ion-icon>
                                </button>
                            </form>

                            <span class="font-black text-xl text-crave-teal w-6 text-center">{{ $item->quantity }}</span>

                            <form action="{{ route('cart.increase') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button type="submit"
                                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-crave-lime text-crave-darkgreen hover:bg-crave-green hover:text-white shadow-sm transition-all border border-transparent">
                                    <ion-icon name="add" class="text-xl"></ion-icon>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-gray-50 p-6 md:p-8 rounded-[2rem] border border-gray-100">
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-base text-gray-500 font-medium">
                        <span>Subtotal Barang</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-base text-gray-500 font-medium">
                        <span>Ongkos Kirim Estimasi</span>
                        <span class="font-bold text-gray-800">Rp 10.000</span>
                    </div>
                    
                    <div class="pt-6 border-t border-dashed border-gray-300 mt-4">
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="block font-black text-gray-900 text-lg">Total Estimasi</span>
                                <span class="block text-xs font-bold text-crave-pink mt-1">*Sudah termasuk pajak</span>
                            </div>
                            <span class="font-black text-3xl md:text-4xl text-crave-darkgreen drop-shadow-sm">Rp {{ number_format($totalPrice + 10000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('checkout') }}"
                    class="w-full bg-gradient-to-r from-crave-lime to-crave-green hover:from-crave-green hover:to-crave-darkgreen text-crave-darkgreen hover:text-white font-black text-xl py-5 rounded-2xl shadow-xl transition-all transform hover:-translate-y-1 flex justify-center items-center gap-3">
                    Lanjut ke Pembayaran <ion-icon name="arrow-forward-outline"></ion-icon>
                </a>
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-center p-10 mt-10">
                <div class="relative w-48 h-48 mb-8">
                    <div class="absolute inset-0 bg-crave-beige rounded-full blur-2xl opacity-50"></div>
                    <div class="relative w-full h-full bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center animate-bounce" style="animation-duration: 3s;">
                        <ion-icon name="basket" class="text-7xl text-crave-orange"></ion-icon>
                    </div>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-3 drop-shadow-sm">Keranjang Kosong</h2>
                <p class="text-gray-500 max-w-sm mb-10 text-lg font-medium">Sepertinya Anda belum menemukan penawaran lezat hari ini. Mari jelajahi!</p>

                <a href="{{ route('home') }}"
                    class="bg-white border-2 border-crave-teal hover:bg-crave-teal text-crave-teal hover:text-white font-bold py-4 px-10 rounded-full transition-all shadow-sm hover:shadow-xl transform hover:-translate-y-1 flex items-center gap-3 text-lg">
                    <ion-icon name="search-outline"></ion-icon> Mulai Menjelajah
                </a>
            </div>
        @endif

    </div>
@endsection

