<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile dashboard.
     */
    public function show(Request $request): View
    {
        $dbOrders = \App\Models\Order::with('items.product')->where('user_id', Auth::id())->latest()->take(5)->get();
        $orders = $dbOrders->map(function($o) {
            $firstItem = $o->items->first();
            $itemName = $firstItem && $firstItem->product ? $firstItem->product->name : 'Pesanan';
            if($o->items->count() > 1) {
                $itemName .= ' + ' . ($o->items->count() - 1) . ' lainnya';
            }
            return [
                'id' => 'ORD-' . $o->order_id,
                'item' => $itemName,
                'price' => $o->totalPrice,
                'status' => ucfirst($o->status),
                'date' => $o->created_at->format('Y-m-d')
            ];
        });

        $dbReviews = \App\Models\Review::with('product.user')->where('user_ID', Auth::id())->latest()->take(5)->get();
        $reviews = $dbReviews->map(function($r) {
            return [
                'seller' => $r->product && $r->product->user ? $r->product->user->username : 'Penjual',
                'rating' => $r->rating,
                'comment' => $r->comment
            ];
        });

        $foodWasteSaved = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->whereIn('status', ['success', 'settlement'])
              ->where('user_id', Auth::id());
        })->with('product')->get()->sum(function($item) {
            return $item->qty * ($item->product->weight_in_grams ?? 0);
        });

        $moneySaved = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->whereIn('status', ['success', 'settlement'])
              ->where('user_id', Auth::id());
        })->with('product')->get()->sum(function($item) {
            return $item->qty * ($item->product->discount ?? 0);
        });

        $stats = [
            'food_saved_kg' => number_format($foodWasteSaved / 1000, 1),
            'money_saved' => $moneySaved,
        ];

        return view('profile.show', compact('orders', 'reviews', 'stats'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
