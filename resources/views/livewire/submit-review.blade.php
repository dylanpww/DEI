<div>
    @if($showModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-all" style="animation: fadeIn 0.2s ease-out;">
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
        </style>
        <div class="bg-white w-full max-w-xl rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-6 md:p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <ion-icon name="star-half-outline" class="text-crave-orange"></ion-icon> Beri Ulasan
                </h3>
                <button wire:click="$set('showModal', false)" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors shadow-sm">
                    <ion-icon name="close-outline" class="text-2xl"></ion-icon>
                </button>
            </div>
            <div class="p-6 md:p-8">
                <p class="text-gray-500 mb-6 text-center text-lg">Bagaimana pengalaman Anda dengan <br><span class="font-bold text-gray-900">{{ $productName }}</span>?</p>
                <form wire:submit="saveReview">
                    <div class="mb-8 flex justify-center gap-3">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('rating', {{ $i }})" class="text-5xl transition-transform hover:scale-110 {{ $i <= $rating ? 'text-crave-orange' : 'text-gray-200 hover:text-gray-300' }}">
                                <ion-icon name="star"></ion-icon>
                            </button>
                        @endfor
                    </div>
                    @error('rating') <span class="text-red-500 text-sm block text-center mb-4">{{ $message }}</span> @enderror
                    
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Komentar / Pengalaman (Opsional)</label>
                        <textarea wire:model="comment" rows="4" class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-crave-lime focus:ring focus:ring-crave-lime/20 p-4 transition-colors text-base resize-none shadow-inner" placeholder="Apakah makanannya enak? Bagaimana porsinya?"></textarea>
                        @error('comment') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex gap-4">
                        <button type="button" wire:click="$set('showModal', false)" class="flex-1 bg-white border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-4 rounded-xl transition-all">Nanti Saja</button>
                        <button type="submit" class="flex-1 bg-crave-lime hover:bg-crave-green text-crave-darkgreen font-bold py-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                            <ion-icon name="paper-plane-outline" class="text-xl"></ion-icon> Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
