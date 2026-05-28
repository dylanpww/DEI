@php
    $isSeller = Auth::id() === $conversation->seller_id;
    $otherUser = $isSeller ? $conversation->buyer : $conversation->seller;
    $unreadCount = $conversation->messages->where('sender_id', '!=', Auth::id())->where('is_read', false)->count();
    $lastMessage = $conversation->messages->sortByDesc('created_at')->first();
@endphp
<a wire:key="conversation-{{ $conversation->id }}" href="{{ route('chat.show', $conversation->id) }}" class="block hover:bg-gray-50 transition-colors p-4 md:p-6">
    <div class="flex items-center gap-4">
        <!-- Avatar -->
        <div class="w-12 h-12 rounded-full bg-crave-teal flex items-center justify-center text-white font-bold text-lg flex-shrink-0 relative">
            {{ strtoupper(substr($otherUser->username ?? 'U', 0, 1)) }}
            @if($unreadCount > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-crave-pink rounded-full border-2 border-white"></span>
            @endif
        </div>
        
        <div class="flex-1 min-w-0">
            <div class="flex justify-between items-baseline mb-1">
                <h3 class="text-base font-bold text-gray-900 truncate flex items-center gap-2">
                    {{ $otherUser->username ?? 'Pengguna Dihapus' }} 
                    <span class="text-xs font-normal text-gray-500">({{ $isSeller ? 'Pembeli' : 'Penjual' }})</span>
                    @if($conversation->order)
                        <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-mono border border-gray-200">#ORD-{{ $conversation->order_id }}</span>
                    @endif
                </h3>
                @if($lastMessage)
                    <span class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $lastMessage->created_at->diffForHumans(null, true, true) }}</span>
                @endif
            </div>
            <p class="text-sm text-crave-teal font-medium truncate mb-1">
                <ion-icon name="fast-food-outline" class="align-middle" wire:ignore></ion-icon> {{ $conversation->product->name ?? 'Produk Dihapus' }}
            </p>
            <p class="text-sm {{ $unreadCount > 0 ? 'text-gray-900 font-semibold' : 'text-gray-500' }} truncate">
                @if($lastMessage)
                    {{ $lastMessage->sender_id === Auth::id() ? 'Anda: ' : '' }}{{ $lastMessage->message }}
                @else
                    Belum ada pesan.
                @endif
            </p>
        </div>
    </div>
</a>
