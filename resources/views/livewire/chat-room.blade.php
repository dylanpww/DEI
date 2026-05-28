<div class="max-w-4xl mx-auto h-[80vh] flex flex-col pb-6" x-data="{ scrollToBottom() { const c = document.getElementById('chat-container'); c.scrollTop = c.scrollHeight; } }" x-init="scrollToBottom()" @message-sent.window="setTimeout(() => scrollToBottom(), 50)">
@php
    $isSeller = Auth::id() === $conversation->seller_id;
    $otherUser = $isSeller ? $conversation->buyer : $conversation->seller;
@endphp
    <!-- Header -->
    <div class="bg-white rounded-t-2xl shadow-sm border-b border-gray-100 p-4 flex items-center justify-between z-10 relative">
        <div class="flex items-center gap-4">
            <a href="{{ route('chat.index') }}" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:text-crave-teal transition-colors">
                <ion-icon name="arrow-back-outline" wire:ignore></ion-icon>
            </a>
            <div class="w-10 h-10 rounded-full bg-crave-teal flex items-center justify-center text-white font-bold text-lg">
                {{ strtoupper(substr($otherUser->username ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h2 class="font-bold text-gray-900">{{ $otherUser->username ?? 'Pengguna Dihapus' }}</h2>
                <p class="text-xs text-crave-teal font-medium">{{ $isSeller ? 'Pembeli' : 'Penjual' }}</p>
            </div>
        </div>
        @if($conversation->product_ID)
        <a href="{{ route('products.show', $conversation->product_ID) }}" class="flex items-center gap-2 bg-gray-50 hover:bg-crave-lime px-3 py-1.5 rounded-lg transition-colors border border-gray-100">
            <ion-icon name="fast-food-outline" class="text-crave-teal" wire:ignore></ion-icon>
            <span class="text-xs font-bold text-gray-700 truncate max-w-[100px] sm:max-w-xs">{{ $conversation->product->name ?? 'Produk Dihapus' }}</span>
        </a>
        @endif
    </div>

    <!-- Messages Area -->
    <div wire:poll.2s class="flex-1 bg-crave-beige overflow-y-auto p-4 md:p-6 space-y-4" id="chat-container">
        @if($conversation->messages->count() === 0)
            <div class="h-full flex flex-col items-center justify-center text-center opacity-50">
                <ion-icon name="chatbubbles" class="text-5xl text-gray-400 mb-2" wire:ignore></ion-icon>
                <p class="text-gray-500 font-medium">Mulai percakapan dengan {{ $otherUser->username ?? 'pengguna ini' }}</p>
            </div>
        @else
            @foreach($conversation->messages->sortBy('created_at') as $message)
                @php
                    $isMe = $message->sender_id === Auth::id();
                @endphp
                <div wire:key="message-{{ $message->id }}" class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] md:max-w-[60%] {{ $isMe ? 'bg-crave-teal text-white rounded-l-2xl rounded-tr-2xl' : 'bg-white text-gray-800 rounded-r-2xl rounded-tl-2xl shadow-sm' }} p-3 md:p-4">
                        <p class="text-sm whitespace-pre-wrap break-words">{{ $message->message }}</p>
                        <div class="flex items-center justify-end gap-1 mt-1 opacity-70">
                            <span class="text-[10px]">{{ $message->created_at->format('H:i') }}</span>
                            @if($isMe)
                                <span class="{{ $message->is_read ? 'text-crave-lime' : 'text-gray-300' }}">
                                    <ion-icon name="checkmark-done-outline" wire:ignore></ion-icon>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Input Area -->
    <div class="bg-white rounded-b-2xl shadow-sm border-t border-gray-100 p-4 flex flex-col gap-3">
        <!-- Quick Options -->
        <div class="flex flex-wrap gap-2">
            @if($isSeller)
                <button type="button" wire:click="sendQuickMessage('Halo, stok makanan ini masih tersedia. Ingin pesan berapa porsi?')" class="text-xs bg-crave-teal/10 hover:bg-crave-teal/20 text-crave-teal px-3 py-1.5 rounded-full transition-colors border border-crave-teal/20 font-medium">Stok Masih Ada</button>
                <button type="button" wire:click="sendQuickMessage('Batas waktu konsumsi makanan ini adalah malam ini/besok pagi. Segera dihabiskan ya!')" class="text-xs bg-crave-teal/10 hover:bg-crave-teal/20 text-crave-teal px-3 py-1.5 rounded-full transition-colors border border-crave-teal/20 font-medium">Batas Konsumsi</button>
                <button type="button" wire:click="sendQuickMessage('Kondisi makanan masih sangat layak dan baik. Kami simpan dengan rapi.')" class="text-xs bg-crave-teal/10 hover:bg-crave-teal/20 text-crave-teal px-3 py-1.5 rounded-full transition-colors border border-crave-teal/20 font-medium">Kondisi Baik</button>
            @else
                <button type="button" wire:click="sendQuickMessage('Halo, apakah stok makanan ini masih ada berapa porsi?')" class="text-xs bg-crave-lime/20 hover:bg-crave-lime/40 text-crave-darkgreen px-3 py-1.5 rounded-full transition-colors border border-crave-lime/30 font-medium">Stok/Kuantitas?</button>
                <button type="button" wire:click="sendQuickMessage('Halo, kapan batas waktu maksimal untuk mengkonsumsi makanan ini?')" class="text-xs bg-crave-lime/20 hover:bg-crave-lime/40 text-crave-darkgreen px-3 py-1.5 rounded-full transition-colors border border-crave-lime/30 font-medium">Batas Waktu Konsumsi?</button>
                <button type="button" wire:click="sendQuickMessage('Halo, bagaimana kondisi dan kualitas makanannya saat ini?')" class="text-xs bg-crave-lime/20 hover:bg-crave-lime/40 text-crave-darkgreen px-3 py-1.5 rounded-full transition-colors border border-crave-lime/30 font-medium">Kondisi Makanan?</button>
            @endif
        </div>

        <form wire:submit.prevent="sendMessage" class="flex gap-2">
            <input type="text" wire:model="message" required autocomplete="off" placeholder="Ketik pesan Anda di sini..." class="flex-1 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-crave-lime focus:ring focus:ring-crave-lime/20 px-4 py-3 transition-colors shadow-inner text-sm">
            <button type="submit" class="bg-crave-lime hover:bg-crave-green text-crave-darkgreen w-12 h-12 rounded-xl flex items-center justify-center text-xl transition-all shadow-sm">
                <ion-icon name="send" wire:ignore></ion-icon>
            </button>
        </form>
    </div>
</div>
