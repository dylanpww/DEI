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
        $conversations = Conversation::with(['buyer', 'seller', 'product', 'order', 'messages' => function($q) {
                $q->latest();
            }])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Categorize based on order status
        $selesai = collect();
        $onProgress = collect();
        
        foreach ($conversations as $conv) {
            $status = $conv->order ? strtolower($conv->order->status) : '';
            if (in_array($status, ['success', 'settlement', 'completed'])) {
                $selesai->push($conv);
            } else {
                // Pending, processing, or no order (pre-sales inquiries) goes to On Progress / Up Coming
                $onProgress->push($conv);
            }
        }

        return view('livewire.chat-list', [
            'selesai' => $selesai,
            'onProgress' => $onProgress,
        ]);
    }
}
