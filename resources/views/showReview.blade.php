@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-12">
        <!-- Tombol Back -->
        <a href="{{ route('my-transactions') }}"
            class="flex items-center gap-2 text-gray-400 hover:text-crave-teal transition-colors mb-8 group">
            <ion-icon name="arrow-back-outline" class="text-xl group-hover:-translate-x-1 transition-transform"></ion-icon>
            <span class="font-bold">Back to Transactions</span>
        </a>

        <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden p-8 md:p-12">
            <div class="text-center mb-8">
                <span
                    class="bg-crave-lime/20 text-crave-darkgreen px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">Your
                    Review</span>
                <h1 class="text-3xl font-black text-crave-teal mt-4">Review for {{ $review->product->name }}</h1>
            </div>

            <!-- Product Preview -->
            <div class="flex items-center gap-4 p-5 bg-gray-50 rounded-3xl mb-8 border border-gray-100">
                <div class="w-16 h-16 bg-crave-beige rounded-2xl overflow-hidden flex-shrink-0">
                    <img src="{{ asset('storage/' . $review->product->image) }}" class="w-full h-full object-cover"
                        onerror="this.src='https://placehold.co/100x100?text=Food'">
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">{{ $review->product->name }}</h4>
                    <p class="text-xs text-gray-400">Review submitted on {{ $review->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Rating Display -->
            <div class="mb-8 text-center">
                <div class="flex justify-center gap-1 text-4xl text-crave-orange mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <ion-icon name="{{ $i <= $review->rating ? 'star' : 'star-outline' }}"></ion-icon>
                    @endfor
                </div>
                <p class="font-bold text-gray-400 uppercase text-xs tracking-widest">
                    {{ $review->rating }} / 5 Stars
                </p>
            </div>

            <!-- Comment -->
            <div class="bg-gray-50 p-8 rounded-[2rem] border border-gray-100 relative">
                <ion-icon name="quote" class="absolute top-4 left-4 text-3xl text-crave-lime/30"></ion-icon>
                <p class="text-gray-700 leading-relaxed italic text-center">
                    "{{ $review->comment ?? 'No comment provided.' }}"
                </p>
            </div>

            <div class="mt-10 text-center">
                <p class="text-sm text-gray-400">
                    Thanks for helping others save food with your feedback!
                </p>
            </div>
        </div>
    </div>
@endsection
