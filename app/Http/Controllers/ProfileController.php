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
        $userId = Auth::id();
        $isSeller = Auth::user()->role === 'seller' || Auth::user()->role === 'admin';

        if ($isSeller) {
            $dbOrders = \App\Models\Order::whereHas('items.product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->with(['items' => function($q) use ($userId) {
                $q->whereHas('product', function($q2) use ($userId) {
                    $q2->where('user_id', $userId);
                });
            }, 'items.product'])->latest()->take(5)->get();

            $orders = $dbOrders->map(function($o) {
                $firstItem = $o->items->first();
                $itemName = $firstItem && $firstItem->product ? $firstItem->product->name : 'Pesanan';
                if($o->items->count() > 1) {
                    $itemName .= ' + ' . ($o->items->count() - 1) . ' lainnya';
                }
                return [
                    'id' => 'ORD-' . $o->order_id,
                    'item' => $itemName,
                    'price' => $o->items->sum('subTotal'), // Only seller's items sum
                    'status' => ucfirst($o->status),
                    'date' => $o->created_at->format('Y-m-d')
                ];
            });

            $dbReviews = \App\Models\Review::whereHas('product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->with('user', 'product')->latest()->take(5)->get();
            
            $reviews = $dbReviews->map(function($r) {
                return [
                    'seller' => $r->user ? $r->user->username : 'Pembeli',
                    'rating' => $r->rating,
                    'comment' => $r->comment
                ];
            });

            $foodWasteSaved = \App\Models\OrderItem::whereHas('product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->whereHas('order', function($q) {
                $q->whereIn('status', ['success', 'settlement']);
            })->with('product')->get()->sum(function($item) {
                return $item->qty * ($item->product->weight_in_grams ?? 0);
            });

            $moneySaved = \App\Models\OrderItem::whereHas('product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->whereHas('order', function($q) {
                $q->whereIn('status', ['success', 'settlement']);
            })->sum('subTotal');
            
            $totalOrders = \App\Models\OrderItem::whereHas('product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->whereHas('order', function($q) {
                $q->whereIn('status', ['success', 'settlement']);
            })->get()->unique('order_id')->count();
            
            $totalReviews = \App\Models\Review::whereHas('product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->count();

        } else {
            $dbOrders = \App\Models\Order::with('items.product')->where('user_id', $userId)->latest()->take(5)->get();
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

            $dbReviews = \App\Models\Review::with('product.user')->where('user_ID', $userId)->latest()->take(5)->get();
            $reviews = $dbReviews->map(function($r) {
                return [
                    'seller' => $r->product && $r->product->user ? $r->product->user->username : 'Penjual',
                    'rating' => $r->rating,
                    'comment' => $r->comment
                ];
            });

            $foodWasteSaved = \App\Models\OrderItem::whereHas('order', function($q) use ($userId) {
                $q->whereIn('status', ['success', 'settlement'])->where('user_id', $userId);
            })->with('product')->get()->sum(function($item) {
                return $item->qty * ($item->product->weight_in_grams ?? 0);
            });

            $moneySaved = \App\Models\OrderItem::whereHas('order', function($q) use ($userId) {
                $q->whereIn('status', ['success', 'settlement'])->where('user_id', $userId);
            })->with('product')->get()->sum(function($item) {
                return $item->qty * ($item->product->discount ?? 0);
            });
            
            $totalOrders = \App\Models\Order::where('user_id', $userId)->whereIn('status', ['success', 'settlement'])->count();
            
            $totalReviews = \App\Models\Review::where('user_ID', $userId)->count();
        }

        $stats = [
            'food_saved_kg' => number_format($foodWasteSaved / 1000, 1),
            'money_saved' => $moneySaved,
            'total_orders' => $totalOrders,
            'total_reviews' => $totalReviews ?? count($dbReviews),
            'is_seller' => $isSeller
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
