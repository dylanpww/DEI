@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pb-20">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-crave-lime to-crave-green rounded-2xl flex items-center justify-center shadow-lg text-white text-3xl">
                    <ion-icon name="receipt-outline"></ion-icon>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-crave-teal drop-shadow-sm">Transaksi Saya</h1>
                    <p class="text-sm font-bold text-gray-400 mt-1 tracking-wide">Pantau semua pesanan dan ulasan Anda</p>
                </div>
            </div>
        </div>

        @if ($orders->isEmpty())
            <div class="bg-white rounded-[2rem] p-16 text-center shadow-sm hover:shadow-xl transition-shadow border border-gray-100 flex flex-col items-center">
                <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mb-6 relative group">
                    <div class="absolute inset-0 bg-crave-lime/20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                    <ion-icon name="receipt-outline" class="text-6xl text-gray-300 relative z-10"></ion-icon>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Belum ada transaksi</h3>
                <p class="text-gray-500 mb-8 max-w-sm">Sepertinya Anda belum menyelamatkan makanan apapun hari ini. Mari mulai berbelanja!</p>
                <a href="{{ route('explore') }}"
                    class="bg-gradient-to-r from-crave-lime to-crave-green text-crave-darkgreen hover:text-white px-10 py-4 rounded-2xl font-black shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-2">
                    <ion-icon name="search" class="text-xl"></ion-icon> Jelajahi Penawaran
                </a>
            </div>
        @else
            <div class="space-y-8">
                @foreach ($orders as $order)
                    <div
                        class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Header Card -->
                        <div class="bg-gradient-to-r from-gray-50 to-white px-8 py-5 flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white rounded-full shadow-sm flex items-center justify-center border border-gray-100">
                                    <ion-icon name="calendar-outline" class="text-crave-teal"></ion-icon>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal Pesanan</span>
                                    <p class="text-base font-black text-crave-teal">
                                        {{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-left md:text-right w-full md:w-auto">
                                <span
                                    class="inline-block px-6 py-2 rounded-xl text-sm font-black tracking-widest shadow-sm border
                                {{ $order->status == 'pending' ? 'bg-orange-50 text-crave-orange border-orange-200' : 'bg-crave-lime/20 text-crave-darkgreen border-crave-lime/50' }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="p-8">
                            <div class="space-y-6">
                                @foreach ($order->items as $item)
                                    <div class="flex flex-col md:flex-row md:items-center gap-6 p-5 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-md transition-all group">
                                        <div class="w-24 h-24 bg-crave-beige rounded-2xl flex-shrink-0 overflow-hidden shadow-inner group-hover:shadow-lg transition-shadow">
                                            @php 
                                                $primaryImage = $item->product->images->first() ? $item->product->images->first()->image_path : $item->product->image;
                                                $stored = $primaryImage && file_exists(public_path('storage/' . $primaryImage)); 
                                            @endphp
                                            @if ($stored)
                                                <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <img src="{{ asset('images/placeholder.svg') }}" alt="Tidak ada gambar"
                                                    class="w-full h-full object-contain p-4 opacity-50">
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <a href="{{ route('products.show', $item->product_id) }}" class="text-xl font-black text-gray-800 hover:text-crave-green transition-colors line-clamp-1">{{ $item->product->name }}</a>
                                            <p class="text-sm font-bold text-gray-500 mt-1">{{ $item->qty }} barang x Rp {{ number_format($item->subTotal / $item->qty, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="md:text-right flex flex-row md:flex-col justify-between items-center md:items-end w-full md:w-auto h-full border-t md:border-t-0 border-gray-200 pt-4 md:pt-0">
                                            <div>
                                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 hidden md:block">Total Harga</p>
                                                <p class="font-black text-2xl text-crave-darkgreen drop-shadow-sm">Rp {{ number_format($item->subTotal, 0, ',', '.') }}</p>
                                            </div>
                                            
                                            @if ($item->product->reviews->isNotEmpty())
                                                <a href="{{ route('reviews.show', $item->product_id) }}"
                                                    class="mt-2 text-white bg-crave-teal hover:bg-crave-darkgreen px-4 py-2 rounded-xl font-bold text-xs flex items-center justify-center gap-1 transition-colors shadow-sm">
                                                    Lihat Review <ion-icon name="chevron-forward-outline"></ion-icon>
                                                </a>
                                            @elseif ($order->status == 'success' || strtolower($order->status) == 'settlement')
                                                <button type="button" x-data @click="$dispatch('open-review-modal', '{{ $item->product_id }}')"
                                                    class="mt-2 text-white bg-crave-orange hover:bg-orange-600 px-4 py-2 rounded-xl font-bold text-xs flex items-center justify-center gap-1 transition-colors shadow-sm">
                                                    Beri Review <ion-icon name="star"></ion-icon>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <livewire:submit-review />
@endsection
