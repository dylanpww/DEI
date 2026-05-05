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
        $orders = [
            ['id' => 'ORD-001', 'item' => 'Surplus Bakery Bread', 'price' => 4.50, 'status' => 'Completed', 'date' => '2026-05-01'],
            ['id' => 'ORD-002', 'item' => 'Leftover Pizza Slice', 'price' => 3.00, 'status' => 'Completed', 'date' => '2026-05-03'],
            ['id' => 'ORD-003', 'item' => 'Veggie Salad Bowl', 'price' => 5.50, 'status' => 'Picked Up', 'date' => '2026-05-04'],
        ];

        $reviews = [
            ['seller' => 'The Daily Bakery', 'rating' => 5, 'comment' => 'The pastries were still super fresh!'],
            ['seller' => 'Pizza Palace', 'rating' => 4, 'comment' => 'Great value for money.'],
        ];

        $favorites = [
            ['name' => 'The Daily Bakery', 'type' => 'Bakery'],
            ['name' => 'Green Leaf Salads', 'type' => 'Healthy'],
        ];

        $stats = [
            'food_saved_kg' => 5.2,
            'money_saved' => 45.00,
        ];

        return view('profile.show', compact('orders', 'reviews', 'favorites', 'stats'));
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
