<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Middleware to log out banned users and invalidate their sessions
class LogoutBannedUser
{
    // Handle an incoming request
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            // If the user is banned (inactive)
            if (!$user->is_active) {
                // Remove all sessions for this user if using the database session driver
                if (config('session.driver') === 'database') {
                    DB::table('sessions')->where('user_id', $user->id)->delete();
                }
                // Log out the user and invalidate the session
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                // Redirect to home with an error message
                return redirect('/')
                    ->withErrors(['email' => 'Your account has been banned and you have been logged out.']);
            }
        }
        // Continue processing the request if not banned
        return $next($request);
    }
}
