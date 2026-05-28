@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-12">
        <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden p-8 md:p-12">

            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-crave-teal mb-2">Beri Ulasan Anda</h1>
                <p class="text-gray-500">Bagaimana pengalaman Anda dengan makanan ini?</p>
            </div>

            <!-- Product Preview -->
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-3xl mb-10 border border-gray-100">
                <div class="w-20 h-20 bg-crave-beige rounded-2xl overflow-hidden flex-shrink-0">
                    @php 
                        $primaryImage = $product->images->first() ? $product->images->first()->image_path : $product->image;
                        $stored = $primaryImage && file_exists(public_path('storage/' . $primaryImage)); 
                    @endphp
                    @if ($stored)
                        <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/placeholder.svg') }}" alt="Tidak ada gambar"
                            class="w-full h-full object-contain p-2">
                    @endif
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">{{ $product->name }}</h4>
                    <p class="text-sm text-crave-darkgreen font-semibold">Dipesan di Crave</p>
                </div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_ID" value="{{ $product->product_ID }}">

                <!-- Star Rating -->
                <div class="mb-8 text-center">
                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Penilaian</label>
                    <div class="flex justify-center gap-2 flex-row-reverse">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                class="hidden peer" required>
                            <label for="star{{ $i }}"
                                class="text-4xl text-gray-300 cursor-pointer hover:text-crave-orange peer-checked:text-crave-orange transition-colors">
                                <ion-icon name="star"></ion-icon>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Comment -->
                <div class="mb-10">
                    <label for="comment" class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Komentar Anda</label>
                    <textarea name="comment" id="comment" rows="4"
                        class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-crave-lime/50 transition-all placeholder:text-gray-300"
                        placeholder="Beri tahu kami tentang rasa, porsi, atau kemasan..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-crave-teal text-white py-5 rounded-2xl font-bold text-xl hover:bg-crave-darkgreen transition-all shadow-xl shadow-teal-100">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>

    <style>
        /* Membuat efek hover bintang yang mengalir (Informatics trick!) */
        label:hover~label {
            color: #FEB837 !important;
        }
    </style>
@endsection
