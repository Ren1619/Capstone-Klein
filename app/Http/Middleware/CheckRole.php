<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Load role relation if not already loaded
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        // Get role name from relation
        $userRoleName = $user->role ? strtolower($user->role->role_name) : '';

        // Check if user has one of the required roles
        foreach ($roles as $role) {
            // Case-insensitive comparison
            if (strtolower($role) === $userRoleName) {
                return $next($request);
            }
        }

        // Log unauthorized access attempt
        \App\Models\Log::create([
            'account_ID' => $user->account_ID,
            'actions' => 'Unauthorized Access Attempt',
            'descriptions' => 'User attempted to access a restricted area: ' . $request->fullUrl(),
            'timestamp' => now(),
        ]);

        // Redirect to dashboard with error message
        return redirect()
            ->route('dashboard')
            ->with('error', 'You do not have permission to access this page.');
    }
}