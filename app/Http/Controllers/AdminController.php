<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Make sure only admin can access these methods
    protected function checkAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();
        $users = User::whereIn('role', ['user', 'seller'])->get();
        $reviews = Review::with(['user', 'product'])->latest()->get();
        
        return view('admin.dashboard', compact('users', 'reviews'));
    }

    public function warnUser(Request $request, $id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        
        // Don't warn admins
        if ($user->role === 'admin') return back()->with('error', 'Cannot warn admins.');

        $user->warning_count += 1;
        
        if ($user->warning_count >= 3) {
            $user->status = 'blocked';
            $user->blocked_until = Carbon::now()->addDays(7);
            $user->warning_count = 0; // Reset after blocking
            $message = 'User received 3rd warning and is automatically blocked for 7 days.';
        } else {
            $message = 'User warned. Total warnings: ' . $user->warning_count;
        }
        
        $user->save();
        return back()->with('success', $message);
    }

    public function blockUser($id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        if ($user->role === 'admin') return back()->with('error', 'Cannot block admins.');
        
        $user->status = 'blocked';
        $user->blocked_until = Carbon::now()->addDays(7);
        $user->save();
        
        return back()->with('success', 'User blocked for 7 days.');
    }

    public function banUser($id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        if ($user->role === 'admin') return back()->with('error', 'Cannot ban admins.');
        
        $user->status = 'banned';
        $user->blocked_until = null;
        $user->save();
        
        return back()->with('success', 'User permanently banned.');
    }

    public function unblockUser($id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        
        $user->status = 'active';
        $user->blocked_until = null;
        $user->warning_count = 0;
        $user->save();
        
        return back()->with('success', 'User status reset to active.');
    }

    public function deleteUser($id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        if ($user->role === 'admin') return back()->with('error', 'Cannot delete admins.');
        
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function updateReview(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return back()->with('success', 'Review updated successfully.');
    }

    public function deleteReview($id)
    {
        $this->checkAdmin();
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
