<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public function render()
    {
        $userId = Auth::id();
        $conversations = Conversation::with(['buyer', 'seller', 'product', 'messages' => function($q) {
                $q->latest();
            }])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('livewire.chat-list', [
            'conversations' => $conversations,
        ]);
    }
}
