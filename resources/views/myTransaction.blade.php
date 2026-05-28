@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pb-20">
        <div class="flex items-center gap-3 mb-8">
            <ion-icon name="receipt-outline" class="text-3xl text-crave-darkgreen"></ion-icon>
            <h1 class="text-3xl font-extrabold text-crave-teal">Transaksi Saya</h1>
        </div>

        @if ($orders->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                <div class="text-6xl mb-4">🛒</div>
                <h3 class="text-xl font-bold text-gray-700">Belum ada transaksi</h3>
                <p class="text-gray-500 mb-6">Sepertinya kamu belum pernah belanja di Crave.</p>
                <a href="{{ route('explore') }}"
                    class="bg-crave-lime text-crave-darkgreen px-8 py-3 rounded-full font-bold hover:bg-crave-green transition-all">Mulai
                    Jelajah</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div
                        class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Header Card -->
                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-100">
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal Pesanan</span>
                                <p class="text-sm font-semibold text-gray-700">
                                    {{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <span
                                    class="inline-block px-4 py-1 rounded-full text-xs font-bold 
                                {{ $order->status == 'pending' ? 'bg-orange-100 text-crave-orange' : 'bg-crave-lime text-crave-darkgreen' }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($order->items as $item)
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 bg-crave-beige rounded-2xl flex-shrink-0 overflow-hidden">
                                            @php 
                                                $primaryImage = $item->product->images->first() ? $item->product->images->first()->image_path : $item->product->image;
                                                $stored = $primaryImage && file_exists(public_path('storage/' . $primaryImage)); 
                                            @endphp
                                            @if ($stored)
                                                <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <img src="{{ asset('images/placeholder.svg') }}" alt="Tidak ada gambar"
                                                    class="w-full h-full object-contain p-2">
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <a href="{{ route('products.show', $item->product_id) }}" class="font-bold text-gray-800 hover:text-crave-teal transition-colors">{{ $item->product->name }}</a>
                                            <p class="text-sm text-gray-500">{{ $item->qty }}x @ Rp
                                                {{ number_format($item->subTotal / $item->qty, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right flex flex-col justify-between items-end h-full">
                                            <p class="font-bold text-gray-800 mb-2">Rp
                                                {{ number_format($item->subTotal, 0, ',', '.') }}</p>
                                            
                                            @if ($item->product->reviews->isNotEmpty())
                                                <a href="{{ route('reviews.show', $item->product_id) }}"
                                                    class="text-crave-darkgreen font-bold text-xs flex items-center justify-end gap-1 hover:underline">
                                                    Lihat Review <ion-icon name="chevron-forward-outline"></ion-icon>
                                                </a>
                                            @elseif ($order->status == 'success' || strtolower($order->status) == 'settlement')
                                                <button type="button" x-data @click="$dispatch('open-review-modal', { productId: {{ $item->product_id }} })"
                                                    class="text-crave-pink font-bold text-xs flex items-center justify-end gap-1 hover:underline">
                                                    Tambah Review <ion-icon name="chevron-forward-outline"></ion-icon>
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
