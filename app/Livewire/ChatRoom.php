<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatRoom extends Component
{
    public $conversation;
    public $message = '';

    public function mount(Conversation $conversation)
    {
        $userId = Auth::id();
        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            abort(403);
        }

        $this->conversation = $conversation;
        $this->markAsRead();
    }

    public function markAsRead()
    {
        Message::where('conversation_id', $this->conversation->id)
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function sendMessage()
    {
        $this->validate(['message' => 'required|string']);

        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => Auth::id(),
            'message' => $this->message,
            'is_read' => false,
        ]);

        $this->conversation->touch();
        $this->message = '';
        
        // Dispatch browser event to scroll down
        $this->dispatch('message-sent');
    }

    public function sendQuickMessage($text)
    {
        $this->message = $text;
        $this->sendMessage();
    }

    public function render()
    {
        $this->conversation->load(['messages.sender', 'buyer', 'seller', 'product']);
        $this->markAsRead();

        return view('livewire.chat-room');
    }
}
