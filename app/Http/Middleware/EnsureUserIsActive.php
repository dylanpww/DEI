<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->status === 'banned') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['email' => 'Your account has been permanently banned.']);
            }

            if ($user->status === 'blocked') {
                if ($user->blocked_until && Carbon::now()->lessThan($user->blocked_until)) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    $date = Carbon::parse($user->blocked_until)->format('M d, Y H:i');
                    return redirect()->route('login')->withErrors(['email' => 'Your account is temporarily blocked until ' . $date . '.']);
                } else {
                    // Block expired, unblock user automatically
                    $user->status = 'active';
                    $user->blocked_until = null;
                    $user->save();
                }
            }
        }

        return $next($request);
    }
}
