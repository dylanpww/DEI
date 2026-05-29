<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $conversations = Conversation::with(['buyer', 'seller', 'product'])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('chat.index', compact('conversations'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $conversation = Conversation::with(['messages.sender', 'buyer', 'seller', 'product'])->findOrFail($id);

        if ($conversation->buyer_id != $userId && $conversation->seller_id != $userId) {
            // abort(403);
        }

        // Tandai sudah dibaca
        Message::where('conversation_id', $id)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.show', compact('conversation'));
    }

    public function start(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $buyerId = Auth::id();
        $sellerId = $product->user_id;

        if ($buyerId === $sellerId) {
            return back()->with('error', 'Anda tidak bisa chat dengan diri sendiri.');
        }

        $conversation = Conversation::firstOrCreate(
            [
                'buyer_id' => $buyerId,
                'seller_id' => $sellerId,
                'product_ID' => $productId,
            ]
        );

        return redirect()->route('chat.show', $conversation->id);
    }

    public function storeMessage(Request $request, $conversationId)
    {
        $request->validate(['message' => 'required|string']);
        
        $conversation = Conversation::findOrFail($conversationId);
        $userId = Auth::id();

        if ($conversation->buyer_id != $userId && $conversation->seller_id != $userId) {
            // abort(403);
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => $request->message,
            'is_read' => false,
        ]);

        $conversation->touch(); // Update updated_at

        return back();
    }
}
