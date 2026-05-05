@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('addresses.index') }}" class="text-gray-400 hover:text-crave-teal mr-4">
            <ion-icon name="arrow-back-outline" class="text-2xl"></ion-icon>
        </a>
        <h1 class="text-2xl font-extrabold text-crave-teal">Edit Address</h1>
    </div>

    <form action="{{ route('addresses.update', $address->Address_ID) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name / Label</label>
                <input type="text" name="name" value="{{ old('name', $address->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-crave-lime focus:border-crave-lime bg-gray-50 p-2.5 border" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telephone Number</label>
                <input type="text" name="telephoneNumber" value="{{ old('telephoneNumber', $address->telephoneNumber) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-crave-lime focus:border-crave-lime bg-gray-50 p-2.5 border" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Complete Address</label>
            <textarea name="completeAddress" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-crave-lime focus:border-crave-lime bg-gray-50 p-2.5 border" required>{{ old('completeAddress', $address->completeAddress) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes for Courier (Optional)</label>
            <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-crave-lime focus:border-crave-lime bg-gray-50 p-2.5 border">{{ old('notes', $address->notes) }}</textarea>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-crave-orange hover:bg-crave-brown text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-sm">
                Update Address
            </button>
        </div>
    </form>
</div>
@endsection