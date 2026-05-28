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
                class="mb-6 bg-crave-beige/20 p-4 rounded-2xl border border-crave-orange/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-start gap-3">
                    <ion-icon name="location" class="text-crave-orange text-3xl mt-1"></ion-icon>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm mb-1">Alamat Pengiriman</h3>
                        @if ($selectedAddress)
                            <p class="text-sm font-bold text-crave-teal">{{ $selectedAddress->name }} <span
                                    class="text-xs text-gray-500 font-normal ml-1">({{ $selectedAddress->telephoneNumber }})</span>
                            </p>
                            <p class="text-xs text-gray-600 mt-0.5 line-clamp-1">{{ $selectedAddress->completeAddress }}</p>
                        @else
                            <p class="text-xs text-crave-pink font-medium mt-1">Belum ada alamat pengiriman yang diatur.</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('addresses.index') }}"
                    class="shrink-0 inline-flex items-center gap-1 text-crave-darkgreen hover:text-white font-bold text-sm bg-white hover:bg-crave-lime border border-crave-lime px-4 py-2 rounded-full shadow-sm transition-all">
                    {{ $selectedAddress ? 'Ubah Alamat' : 'Tambah Alamat' }}
                </a>
            </div>

            <div class="flex-1 overflow-y-auto space-y-5 pr-2">
                @foreach ($cartItems as $item)
                    <div
                        class="flex items-center justify-between bg-gray-50/50 p-4 rounded-2xl border border-gray-100 hover:border-crave-lime/50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-20 h-20 bg-crave-beige rounded-xl flex items-center justify-center p-2 shadow-inner">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                    class="object-contain w-full h-full drop-shadow-sm">
                            </div>
                            <div class="flex flex-col justify-center">
                                <h3 class="font-bold text-base text-crave-teal">{{ $item->name }}</h3>
                                <p class="text-xs text-gray-500 mb-1">{{ $item->unit }}</p>
                                <p class="font-extrabold text-sm text-crave-darkgreen">Rp
                                    {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 bg-white p-1 rounded-full border border-gray-200 shadow-sm">
                            <form action="{{ route('cart.decrease') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button type="submit"
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-crave-teal transition-colors">
                                    <ion-icon name="remove"></ion-icon>
                                </button>
                            </form>

                            <span class="font-bold text-crave-teal w-4 text-center">{{ $item->quantity }}</span>

                            <form action="{{ route('cart.increase') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button type="submit"
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-crave-lime text-white hover:bg-crave-green transition-colors">
                                    <ion-icon name="add"></ion-icon>
                                </button>
                            </form>
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
                        <span>Ongkos Kirim</span>
                        <span class="font-medium text-gray-800">Rp 10.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-dashed border-gray-200 mt-3">
                        <span class="font-bold text-gray-800 text-base">Total Estimasi</span>
                        <span class="font-extrabold text-xl text-crave-darkgreen">Rp
                            {{ number_format($totalPrice + 10000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout') }}"
                    class="w-full bg-crave-green hover:bg-crave-darkgreen text-white font-bold text-lg py-4 rounded-2xl shadow-md transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    Lanjut ke Pembayaran <ion-icon name="arrow-forward-outline"></ion-icon>
                </a>
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-center p-10">
                <div class="w-48 h-48 bg-crave-beige/50 rounded-full flex items-center justify-center mb-6">
                    <ion-icon name="basket-outline" class="text-7xl text-crave-orange/50"></ion-icon>
                </div>
                <h2 class="text-2xl font-bold text-crave-teal mb-2">Keranjang Anda kosong</h2>
                <p class="text-gray-500 max-w-xs mb-8">Sepertinya Anda belum menambahkan apa pun ke keranjang Anda. Ayo temukan
                    makanan sisa yang lezat!</p>

                <a href="{{ route('home') }}"
                    class="bg-crave-orange hover:bg-crave-brown text-white font-bold py-3 px-8 rounded-full transition-all shadow-md transform hover:-translate-y-0.5 flex items-center gap-2">
                    <ion-icon name="search-outline"></ion-icon> Mulai Menjelajah
                </a>
            </div>
        @endif

    </div>
@endsection

