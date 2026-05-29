@extends('layouts.app')

@section('title', 'My Shop Dashboard - Crave')

@section('content')
    <div class="space-y-8">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-crave-teal">Dasbor Toko</h1>
                <p class="text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->username }}. Berikut adalah perkembangan toko Anda.
                </p>
            </div>
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-crave-teal hover:bg-crave-darkgreen text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg">
                <ion-icon name="add-circle-outline" class="text-xl mr-2"></ion-icon>
                Tambah Produk Baru
            </a>
        </div>

        <!-- Analytics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center space-x-4">
                <div
                    class="w-12 h-12 rounded-full bg-crave-beige text-crave-orange flex items-center justify-center text-2xl">
                    <ion-icon name="wallet"></ion-icon>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-green-50 text-crave-green flex items-center justify-center text-2xl">
                    <ion-icon name="bag-check"></ion-icon>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPesanan }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-2xl">
                    <ion-icon name="fast-food"></ion-icon>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Produk Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $products->where('status', 'available')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center text-2xl">
                    <ion-icon name="star"></ion-icon>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Penilaian Toko</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $avgRating }} <span class="text-sm text-gray-400 font-normal">/
                            5</span></p>
                </div>
            </div>
        </div>

        <!-- My Products Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-800">Produk Saya</h2>
            </div>

            @if ($products->isEmpty())
                <div class="p-12 text-center">
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-4xl">
                        <ion-icon name="basket-outline"></ion-icon>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada produk</h3>
                    <p class="text-gray-500 mb-4">Mulai daftarkan makanan sisa Anda untuk mengurangi limbah dan mendapatkan pendapatan.</p>
                    <a href="{{ route('products.create') }}"
                        class="text-crave-green font-semibold hover:text-crave-darkgreen">Tambahkan produk pertama Anda &rarr;</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-medium">Produk</th>
                                <th class="px-6 py-4 font-medium">Harga</th>
                                <th class="px-6 py-4 font-medium">Stok</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @php 
                                                $primaryImage = $product->images->first() ? $product->images->first()->image_path : $product->image;
                                            @endphp
                                            @if ($primaryImage)
                                                <img src="{{ asset('storage/' . $primaryImage) }}"
                                                    alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100">
                                            @else
                                                <div
                                                    class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                    <ion-icon name="image-outline"></ion-icon>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $product->category->name ?? 'Tidak Berkategori' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($product->discount > 0)
                                            <p class="text-crave-pink font-bold">Rp
                                                {{ number_format($product->actualPrice - $product->discount, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-gray-400 line-through">Rp
                                                {{ number_format($product->actualPrice, 0, ',', '.') }}</p>
                                        @else
                                            <p class="font-medium text-gray-900">Rp
                                                {{ number_format($product->actualPrice, 0, ',', '.') }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-700">{{ $product->stock }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($product->status == 'available')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Tersedia</span>
                                        @elseif($product->status == 'sold_out')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Habis</span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Kedaluwarsa</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div
                                            class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('products.show', $product->product_ID) }}"
                                                class="p-2 text-gray-400 hover:text-crave-teal hover:bg-gray-100 rounded-lg transition-colors"
                                                title="View">
                                                <ion-icon name="eye-outline" class="text-lg"></ion-icon>
                                            </a>
                                            <a href="{{ route('products.edit', $product->product_ID) }}"
                                                class="p-2 text-gray-400 hover:text-crave-orange hover:bg-orange-50 rounded-lg transition-colors"
                                                title="Edit">
                                                <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->product_ID) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Hapus">
                                                    <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-8">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
            </div>
            @if($recentOrders->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    <ion-icon name="receipt-outline" class="text-4xl mb-2 text-gray-300"></ion-icon>
                    <p>Riwayat pesanan akan muncul di sini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-medium">Pembeli</th>
                                <th class="px-6 py-4 font-medium">Item</th>
                                <th class="px-6 py-4 font-medium">Total</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $order->user->username ?? 'Guest' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $order->items->sum('qty') }} porsi ({{ $order->items->first()->product->name ?? 'Produk' }}...)
                                    </td>
                                    <td class="px-6 py-4 font-bold text-crave-darkgreen">Rp {{ number_format($order->items->sum('subTotal'), 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $order->status == 'pending' ? 'bg-orange-50 text-crave-orange border-orange-200' : 'bg-crave-lime/20 text-crave-darkgreen border-crave-lime/50' }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs font-medium">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
