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
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-crave-lime transition-colors relative group">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center space-x-2">
                        <ion-icon name="location" class="text-crave-orange text-2xl"></ion-icon>
                        <h2 class="text-xl font-bold text-gray-800">{{ $address->name }}</h2>
                    </div>
                    
                    <div class="flex space-x-3 text-gray-400">
                        <a href="{{ route('addresses.edit', $address->Address_ID) }}" class="hover:text-crave-teal transition-colors" title="Edit">
                            <ion-icon name="create-outline" class="text-xl"></ion-icon>
                        </a>
                        <form action="{{ route('addresses.destroy', $address->Address_ID) }}" method="POST" class="inline" onsubmit="return confirm('Delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-crave-pink transition-colors" title="Delete">
                                <ion-icon name="trash-outline" class="text-xl"></ion-icon>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-gray-600 space-y-2 text-sm">
                    <p class="font-medium flex items-center"><ion-icon name="call-outline" class="mr-2"></ion-icon> {{ $address->telephoneNumber }}</p>
                    <p class="mt-2">{{ $address->completeAddress }}</p>
                    @if($address->notes)
                        <p class="text-gray-400 italic mt-2 text-xs">Notes: {{ $address->notes }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 bg-crave-beige/30 rounded-2xl p-10 text-center border border-dashed border-crave-orange/50">
                <ion-icon name="map-outline" class="text-5xl text-crave-orange/50 mb-3"></ion-icon>
                <h3 class="text-lg font-bold text-crave-brown mb-2">No addresses found</h3>
                <p class="text-gray-500 mb-4">You haven't added any delivery addresses yet.</p>
                <a href="{{ route('addresses.create') }}" class="text-crave-green hover:text-crave-darkgreen font-medium underline">Add one now</a>
            </div>
        @endforelse
    </div>
</div>
@endsection