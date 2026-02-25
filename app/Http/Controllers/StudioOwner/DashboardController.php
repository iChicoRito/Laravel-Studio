<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingModel;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioOwner\StudioPhotographersModel;
use App\Models\PaymentModel;

class DashboardController extends Controller
{
    /**
     * Display the studio owner dashboard with real statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Get the studio owned by this user
        $studio = StudiosModel::where('user_id', $user->id)->first();
        
        // If no studio found, return view with zero values
        if (!$studio) {
            return view('owner.dashboard', [
                'totalEarnings' => 0,
                'totalBookings' => 0,
                'completedBookings' => 0,
                'totalPhotographers' => 0,
                'studio' => null
            ]);
        }
        
        // Get total earnings from completed bookings with successful payments
        $totalEarnings = BookingModel::where('provider_id', $studio->id)
            ->where('booking_type', 'studio')
            ->where('status', BookingModel::STATUS_COMPLETED)
            ->where('payment_status', BookingModel::PAYMENT_PAID)
            ->sum('total_amount');
        
        // Get total bookings (pending + confirmed + in_progress)
        $totalBookings = BookingModel::where('provider_id', $studio->id)
            ->where('booking_type', 'studio')
            ->whereIn('status', [
                BookingModel::STATUS_PENDING,
                BookingModel::STATUS_CONFIRMED,
                BookingModel::STATUS_IN_PROGRESS
            ])
            ->count();
        
        // Get completed bookings
        $completedBookings = BookingModel::where('provider_id', $studio->id)
            ->where('booking_type', 'studio')
            ->where('status', BookingModel::STATUS_COMPLETED)
            ->count();
        
        // Get total active studio photographers
        $totalPhotographers = StudioPhotographersModel::where('studio_id', $studio->id)
            ->where('status', 'active')
            ->count();
        
        return view('owner.dashboard', compact(
            'totalEarnings',
            'totalBookings',
            'completedBookings',
            'totalPhotographers',
            'studio'
        ));
    }
}