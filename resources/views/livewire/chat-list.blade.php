<div wire:poll.2s x-data="{ activeTab: 'onProgress' }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Tabs Header -->
    <div class="flex border-b border-gray-100 p-2 gap-2 bg-gray-50/50">
        <button @click="activeTab = 'onProgress'" 
            :class="{'bg-white shadow-sm border-gray-200 text-crave-darkgreen': activeTab === 'onProgress', 'text-gray-500 hover:bg-white/50 border-transparent': activeTab !== 'onProgress'}" 
            class="flex-1 py-3 px-4 rounded-xl font-bold text-sm transition-all border flex items-center justify-center gap-2">
            <ion-icon name="time-outline" class="text-lg"></ion-icon> Akan Datang / Diproses
        </button>
        <button @click="activeTab = 'selesai'" 
            :class="{'bg-white shadow-sm border-gray-200 text-crave-darkgreen': activeTab === 'selesai', 'text-gray-500 hover:bg-white/50 border-transparent': activeTab !== 'selesai'}" 
            class="flex-1 py-3 px-4 rounded-xl font-bold text-sm transition-all border flex items-center justify-center gap-2">
            <ion-icon name="checkmark-done-circle-outline" class="text-lg"></ion-icon> Selesai
        </button>
    </div>

    <!-- On Progress Tab -->
    <div x-show="activeTab === 'onProgress'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
        @if($onProgress->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($onProgress as $conversation)
                    @include('livewire.partials.chat-item', ['conversation' => $conversation])
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <ion-icon name="chatbubbles-outline" class="text-6xl text-gray-200 mb-4" wire:ignore></ion-icon>
                <h3 class="text-lg font-bold text-gray-700 mb-1">Belum Ada Pesan Aktif</h3>
                <p class="text-gray-500 text-sm">Tidak ada transaksi yang sedang berlangsung.</p>
            </div>
        @endif
    </div>

    <!-- Selesai Tab -->
    <div x-show="activeTab === 'selesai'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
        @if($selesai->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($selesai as $conversation)
                    @include('livewire.partials.chat-item', ['conversation' => $conversation])
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <ion-icon name="checkmark-done-circle-outline" class="text-6xl text-gray-200 mb-4" wire:ignore></ion-icon>
                <h3 class="text-lg font-bold text-gray-700 mb-1">Belum Ada Pesan Selesai</h3>
                <p class="text-gray-500 text-sm">Pesan dari pesanan yang sudah sukses akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>
