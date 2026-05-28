<div wire:poll.5s class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        <ion-icon name="star" class="text-crave-orange"></ion-icon> Ulasan Produk ({{ $product->reviews->count() }})
    </h2>
    
    @if($product->reviews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($product->reviews->sortByDesc('created_at') as $review)
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-crave-teal rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($review->user->username, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $review->user->username }}</h4>
                                <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex text-crave-orange text-sm">
                            @for($i=0; $i<$review->rating; $i++)
                                <ion-icon name="star"></ion-icon>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $review->comment ?: 'Tidak ada komentar.' }}</p>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 bg-gray-50 rounded-2xl">
            <ion-icon name="chatbubbles-outline" class="text-5xl text-gray-300 mb-3"></ion-icon>
            <p class="text-gray-500 font-medium">Belum ada ulasan untuk produk ini.</p>
            <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama untuk memberikan ulasan setelah membeli!</p>
        </div>
    @endif
</div>
