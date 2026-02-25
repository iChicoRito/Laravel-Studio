<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StudioPhotographerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        // Check if user has the correct role
        $user = Auth::user();
        if ($user->role !== 'studio-photographer') {
            // Redirect based on user's actual role
            $routes = [
                'admin' => 'admin.dashboard',
                'owner' => 'owner.dashboard',
                'freelancer' => 'freelancer.dashboard',
                'client' => 'client.dashboard',
                'studio-photographer' => 'studio-photographer.dashboard'
            ];
            
            $route = $routes[$user->role] ?? 'login';
            return redirect()->route($route)->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}