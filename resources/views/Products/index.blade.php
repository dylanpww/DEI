@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-crave-teal">My Products</h2>
        <a href="{{ route('products.create') }}" class="bg-crave-lime hover:bg-crave-green text-crave-teal font-bold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
            <ion-icon name="add-circle-outline"></ion-icon> Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-crave-beige text-crave-brown p-4 rounded-lg mb-6 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b">Name</th>
                    <th class="p-4 border-b">Category</th>
                    <th class="p-4 border-b">Price</th>
                    <th class="p-4 border-b">Stock</th>
                    <th class="p-4 border-b">Status</th>
                    <th class="p-4 border-b text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 border-b font-medium">{{ $product->name }}</td>
                    <td class="p-4 border-b">{{ $product->category->name }}</td>
                    <td class="p-4 border-b">
                        Rp {{ number_format($product->actualPrice, 0, ',', '.') }}
                        @if($product->discount > 0)
                            <br><span class="text-crave-pink text-xs">-Rp {{ number_format($product->discount, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="p-4 border-b">{{ $product->stock }}</td>
                    <td class="p-4 border-b">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->status == 'available' ? 'bg-crave-lime text-crave-teal' : 'bg-gray-200 text-gray-500' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td class="p-4 border-b text-right flex justify-end gap-2">
                        <a href="{{ route('products.show', $product->product_ID) }}" class="text-crave-teal hover:text-white hover:bg-crave-teal bg-gray-100 p-2 rounded-md transition-colors">
                            <ion-icon name="eye-outline"></ion-icon>
                        </a>
                        <a href="{{ route('products.edit', $product->product_ID) }}" class="text-crave-orange hover:text-crave-brown bg-crave-lightyellow p-2 rounded-md">
                            <ion-icon name="create-outline"></ion-icon>
                        </a>
                        <form action="{{ route('products.destroy', $product->product_ID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white hover:bg-red-600 bg-crave-pink p-2 rounded-md">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">No products found. Start saving food!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection