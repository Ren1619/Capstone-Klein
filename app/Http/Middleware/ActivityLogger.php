<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use Carbon\Carbon;

class ActivityLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Don't log GET requests or auth-related routes to avoid excessive logging
            if ($request->method() !== 'GET' && 
                !$this->isAuthRoute($request) && 
                !$this->isAssetRoute($request)) {
                
                Log::create([
                    'account_ID' => $user->account_ID,
                    'actions' => $this->determineAction($request),
                    'descriptions' => $this->generateDescription($request),
                    'timestamp' => Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Determine if the request is for an authentication route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isAuthRoute($request)
    {
        $authRoutes = [
            'login',
            'logout',
            'password/email',
            'password/reset',
            'password/confirm',
            'email/verification-notification',
        ];

        return collect($authRoutes)->contains(function ($route) use ($request) {
            return $request->is($route) || $request->is("*/{$route}");
        });
    }

    /**
     * Determine if the request is for an asset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isAssetRoute($request)
    {
        return $request->is('css/*') || 
               $request->is('js/*') || 
               $request->is('images/*') || 
               $request->is('fonts/*');
    }

    /**
     * Determine the action being performed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function determineAction($request)
    {
        $method = $request->method();
        $path = $request->path();
        
        // Extract the action from the route
        if ($method === 'POST' && strpos($path, '/store') !== false) {
            return 'Create';
        } elseif ($method === 'PUT' || $method === 'PATCH' || strpos($path, '/update') !== false) {
            return 'Update';
        } elseif ($method === 'DELETE' || strpos($path, '/destroy') !== false) {
            return 'Delete';
        } else {
            return $method;
        }
    }

    /**
     * Generate a description for the log entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function generateDescription($request)
    {
        $method = $request->method();
        $path = $request->path();
        $user = Auth::user();
        
        // Extract the resource type from the path
        $segments = explode('/', $path);
        $resource = count($segments) > 0 ? $segments[0] : 'resource';
        
        // Singularize the resource (simple method)
        $resource = rtrim($resource, 's');
        
        // Generate appropriate description
        switch ($method) {
            case 'POST':
                return "User {$user->account_ID} ({$user->email}) created a new {$resource}";
            case 'PUT':
            case 'PATCH':
                return "User {$user->account_ID} ({$user->email}) updated a {$resource}";
            case 'DELETE':
                return "User {$user->account_ID} ({$user->email}) deleted a {$resource}";
            default:
                return "User {$user->account_ID} ({$user->email}) performed action on {$path}";
        }
    }
}