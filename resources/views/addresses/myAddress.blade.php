@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-crave-teal">My Addresses</h1>
        <a href="{{ route('addresses.create') }}" class="bg-crave-green hover:bg-crave-darkgreen text-white px-5 py-2.5 rounded-full font-medium transition-colors flex items-center shadow-sm">
            <ion-icon name="add-outline" class="mr-2 text-xl"></ion-icon> Add New
        </a>
    </div>

    @if(session('success'))
        <div class="bg-crave-lime/20 border-l-4 border-crave-green text-crave-darkgreen p-4 mb-6 rounded-r-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($addresses as $address)
            <div class="bg-white rounded-2xl p-6 shadow-sm border {{ session('selected_address_id') == $address->Address_ID ? 'border-crave-lime ring-2 ring-crave-lime/20' : 'border-gray-100' }} hover:border-crave-lime transition-all relative">
                
                <div class="flex justify-between items-start mb-4 gap-2">
                    <div class="flex items-center space-x-2">
                        <ion-icon name="location" class="text-crave-orange text-2xl shrink-0"></ion-icon>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <h2 class="text-lg font-bold text-gray-800 leading-tight">{{ $address->name }}</h2>
                            @if(session('selected_address_id') == $address->Address_ID)
                                <span class="bg-crave-lime text-crave-teal text-[10px] font-extrabold px-2 py-0.5 rounded-full uppercase w-fit">Active</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-gray-400 shrink-0">
                        @if(session('selected_address_id') != $address->Address_ID)
                            <form action="{{ route('cart.selectAddress') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="address_id" value="{{ $address->Address_ID }}">
                                <button type="submit" class="text-xs bg-gray-100 text-gray-600 font-bold px-3 py-1.5 rounded-full hover:bg-crave-lime hover:text-crave-teal transition-colors">
                                    Use This
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('addresses.edit', $address->Address_ID) }}" class="hover:text-crave-teal transition-colors flex items-center" title="Edit Address">
                            <ion-icon name="create-outline" class="text-xl"></ion-icon>
                        </a>

                        <form action="{{ route('addresses.destroy', $address->Address_ID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-crave-pink transition-colors flex items-center" title="Delete Address">
                                <ion-icon name="trash-outline" class="text-xl"></ion-icon>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-gray-600 space-y-2 text-sm">
                    <p class="font-medium flex items-center">
                        <ion-icon name="call-outline" class="mr-2"></ion-icon> {{ $address->telephoneNumber }}
                    </p>
                    <p class="text-gray-500 leading-relaxed">
                        {{ $address->completeAddress }}
                    </p>
                    @if($address->notes)
                        <p class="text-gray-400 italic text-xs mt-2 border-t pt-2">Note: {{ $address->notes }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-gray-50 rounded-2xl p-12 text-center border-2 border-dashed border-gray-200">
                <ion-icon name="map-outline" class="text-5xl text-gray-300 mb-3"></ion-icon>
                <p class="text-gray-500 font-medium">No addresses found.</p>
                <a href="{{ route('addresses.create') }}" class="text-crave-green hover:underline text-sm mt-2 inline-block">Add your first address</a>
            </div>
        @endforelse
    </div>
</div>
@endsection