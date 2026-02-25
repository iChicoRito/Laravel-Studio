<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioPlanModel;

class CheckStudioRegistrationLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Only apply to studio owners
        if (!$user || $user->role !== 'owner') {
            return $next($request);
        }
        
        // Count existing studios for this owner
        $studioCount = StudiosModel::where('user_id', $user->id)->count();
        
        // Get all studio IDs owned by this user
        $userStudioIds = StudiosModel::where('user_id', $user->id)->pluck('id')->toArray();
        
        // Check if ANY of the user's studios have an active subscription
        $activeSubscription = null;
        if (!empty($userStudioIds)) {
            $activeSubscription = StudioPlanModel::whereIn('studio_id', $userStudioIds)
                ->with('plan')
                ->where('status', 'active')
                ->where('payment_status', 'paid')
                ->where('end_date', '>=', now()->toDateString())
                ->latest()
                ->first();
        }
        
        \Log::info('Studio Registration Middleware Check', [
            'user_id' => $user->id,
            'studio_count' => $studioCount,
            'user_studio_ids' => $userStudioIds,
            'has_subscription' => $activeSubscription ? true : false,
            'path' => $request->path(),
            'method' => $request->method()
        ]);
        
        // If user already has at least one studio, check subscription
        if ($studioCount >= 1) {
            if (!$activeSubscription) {
                // No active subscription - block registration of additional studios
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You need an active subscription plan to register multiple studios.',
                        'alert_color' => '#DC3545',
                        'redirect' => route('owner.subscription.index')
                    ], 403);
                }
                
                return redirect()->route('owner.subscription.index')
                    ->with('error', 'You need an active subscription plan to register multiple studios.');
            }
            
            // Check if subscription allows multiple studios
            if ($activeSubscription && $activeSubscription->plan) {
                $maxStudios = $activeSubscription->plan->max_studios;
                
                \Log::info('Subscription Limits', [
                    'max_studios' => $maxStudios,
                    'current_count' => $studioCount
                ]);
                
                // If max_studios is null, it means unlimited
                if ($maxStudios !== null) {
                    // For store request, we need to check if adding one more would exceed limit
                    if ($request->isMethod('post') && $studioCount >= $maxStudios) {
                        if ($request->expectsJson()) {
                            return response()->json([
                                'success' => false,
                                'message' => "Your subscription plan only allows up to {$maxStudios} studio(s). You have already reached this limit.",
                                'alert_color' => '#DC3545'
                            ], 403);
                        }
                        
                        return redirect()->route('owner.subscription.index')
                            ->with('error', "Your subscription plan only allows up to {$maxStudios} studio(s). You have already reached this limit.");
                    }
                    
                    // For create form access, check if already at limit
                    if ($request->isMethod('get') && $studioCount >= $maxStudios) {
                        if ($request->expectsJson()) {
                            return response()->json([
                                'success' => false,
                                'message' => "Your subscription plan only allows up to {$maxStudios} studio(s).",
                                'alert_color' => '#DC3545'
                            ], 403);
                        }
                        
                        return redirect()->route('owner.subscription.index')
                            ->with('error', "Your subscription plan only allows up to {$maxStudios} studio(s).");
                    }
                }
            }
        }
        
        // First studio registration or has valid subscription with capacity
        return $next($request);
    }
}