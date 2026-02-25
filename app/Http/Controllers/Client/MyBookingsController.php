<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingModel;
use App\Models\BookingPackageModel;
use App\Models\PaymentModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyBookingsController extends Controller
{
    /**
     * Display current bookings (pending, confirmed, in_progress)
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Get current and upcoming bookings
        $bookings = BookingModel::where('client_id', $userId)
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->orderBy('event_date', 'asc')
            ->with([
                'category:id,category_name',
                'packages:id,booking_id,package_name,package_price',
                'payments:id,booking_id,amount,status'
            ])
            ->paginate(10);
        
        // Manually load provider details after fetching bookings and add downpayment percentage
        $bookings->each(function($booking) {
            if ($booking->booking_type === 'studio') {
                $studio = \App\Models\StudioOwner\StudiosModel::where('id', $booking->provider_id)
                    ->select('id', 'studio_name', 'studio_logo', 'downpayment_percentage')
                    ->first();
                $booking->provider = $studio;
                $booking->downpayment_percentage = $studio->downpayment_percentage ?? 30;
            } else {
                $freelancer = \App\Models\Freelancer\ProfileModel::where('user_id', $booking->provider_id)
                    ->select('user_id', 'brand_name', 'brand_logo')
                    ->first();
                $booking->provider = $freelancer;
                $booking->downpayment_percentage = 30; // Default for freelancer
            }
        });
        
        return view('client.view-my-bookings', compact('bookings'));
    }

    /**
     * Display booking history (completed, cancelled)
     */
    public function history(Request $request)
    {
        $userId = Auth::id();
        
        // Get completed/cancelled bookings
        $bookings = BookingModel::where('client_id', $userId)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('event_date', 'desc')
            ->with([
                'category:id,category_name',
                'packages:id,booking_id,package_name,package_price',
                'payments:id,booking_id,amount,status'
            ])
            ->paginate(10);
        
        // Manually load provider details after fetching bookings
        $bookings->each(function($booking) {
            if ($booking->booking_type === 'studio') {
                $booking->provider = \App\Models\StudioOwner\StudiosModel::where('id', $booking->provider_id)
                    ->select('id', 'studio_name', 'studio_logo')
                    ->first();
            } else {
                $booking->provider = \App\Models\Freelancer\ProfileModel::where('user_id', $booking->provider_id)
                    ->select('user_id', 'brand_name', 'brand_logo')
                    ->first();
            }
        });
        
        return view('client.view-booking-history', compact('bookings'));
    }

    /**
     * Get booking details for modal
     */
    public function getBookingDetails($id)
    {
        try {
            $userId = Auth::id();
            
            $booking = BookingModel::where('client_id', $userId)
                ->with([
                    'category:id,category_name',
                    'packages:id,booking_id,package_name,package_price,package_inclusions,duration,maximum_edited_photos,coverage_scope',
                    'payments:id,booking_id,amount,status,payment_method,paid_at,payment_reference',
                    'assignedPhotographers.photographer:id,first_name,last_name',
                    'assignedPhotographers.studioPhotographer:id,photographer_id,position,specialization,years_of_experience'
                ])
                ->findOrFail($id);
            
            // Get provider details based on booking type
            $provider = null;
            $providerType = null;
            $downpaymentPercentage = 30; // Default fallback
            
            if ($booking->booking_type === 'studio') {
                $provider = \App\Models\StudioOwner\StudiosModel::where('id', $booking->provider_id)
                    ->select('id', 'studio_name', 'studio_logo', 'contact_number', 'studio_email', 'starting_price', 'downpayment_percentage')
                    ->first();
                $providerType = 'studio';
                
                // Get downpayment percentage from studio
                if ($provider && $provider->downpayment_percentage) {
                    $downpaymentPercentage = $provider->downpayment_percentage;
                }
            } else {
                $provider = \App\Models\Freelancer\ProfileModel::where('user_id', $booking->provider_id)
                    ->select('user_id as id', 'brand_name', 'brand_logo', 'starting_price')
                    ->first();
                $providerType = 'freelancer';
                
                // Get user contact info
                if ($provider) {
                    $user = \App\Models\UserModel::where('id', $booking->provider_id)
                        ->select('id', 'email', 'mobile_number')
                        ->first();
                    $provider->contact_email = $user->email ?? null;
                    $provider->contact_number = $user->mobile_number ?? null;
                }
                
                // For freelancer, you can set a default or add a column later
                $downpaymentPercentage = 30; // Default for freelancer
            }
            
            // Calculate payment summary
            $totalPaid = $booking->payments->where('status', 'succeeded')->sum('amount');
            $remainingBalance = $booking->total_amount - $totalPaid;
            
            return response()->json([
                'success' => true,
                'booking' => $booking,
                'provider' => $provider,
                'provider_type' => $providerType,
                'category' => $booking->category,
                'packages' => $booking->packages,
                'payments' => $booking->payments,
                'assignedPhotographers' => $booking->assignedPhotographers,
                'downpayment_percentage' => $downpaymentPercentage, // ADD THIS
                'payment_summary' => [
                    'total_amount' => $booking->total_amount,
                    'down_payment' => $booking->down_payment,
                    'total_paid' => $totalPaid,
                    'remaining_balance' => $remainingBalance
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel booking
     */
    public function cancelBooking($id)
    {
        try {
            $userId = Auth::id();
            
            $booking = BookingModel::where('client_id', $userId)
                ->where('id', $id)
                ->where('status', 'pending')
                ->firstOrFail();
            
            // Check if booking can be cancelled (at least 24 hours before event)
            $eventDate = Carbon::parse($booking->event_date);
            $now = Carbon::now();
            
            if ($now->diffInHours($eventDate, false) < 24) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bookings can only be cancelled at least 24 hours before the event date.'
                ]);
            }
            
            $booking->update([
                'status' => 'cancelled',
                'payment_status' => 'cancelled'
            ]);
            
            // Cancel any pending payments
            PaymentModel::where('booking_id', $id)
                ->where('status', 'pending')
                ->update(['status' => 'cancelled']);
            
            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling booking: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment details for remaining balance
     */
    public function getPaymentDetails($id)
    {
        try {
            $userId = Auth::id();
            
            $booking = BookingModel::where('client_id', $userId)
                ->where('id', $id)
                ->whereIn('status', ['confirmed', 'in_progress'])
                ->whereIn('payment_status', ['pending', 'partially_paid'])
                ->firstOrFail();
            
            // Calculate payment info
            $totalPaid = $booking->payments()->where('status', 'succeeded')->sum('amount');
            $remainingBalance = $booking->total_amount - $totalPaid;
            
            // Check if there's already a pending payment
            $pendingPayment = $booking->payments()
                ->where('status', 'pending')
                ->latest()
                ->first();
            
            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->id,
                    'reference' => $booking->booking_reference,
                    'total_amount' => $booking->total_amount,
                    'total_paid' => $totalPaid,
                    'remaining_balance' => $remainingBalance,
                    'payment_status' => $booking->payment_status,
                    'booking_status' => $booking->status
                ],
                'has_pending_payment' => $pendingPayment ? true : false,
                'pending_payment_id' => $pendingPayment ? $pendingPayment->id : null
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching payment details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Initialize payment for remaining balance
     */
    public function initializeBalancePayment(Request $request, $id)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:1'
            ]);
            
            $userId = Auth::id();
            
            $booking = BookingModel::where('client_id', $userId)
                ->where('id', $id)
                ->whereIn('status', ['confirmed', 'in_progress'])
                ->whereIn('payment_status', ['pending', 'partially_paid'])
                ->firstOrFail();
            
            // Calculate remaining balance
            $totalPaid = $booking->payments()->where('status', 'succeeded')->sum('amount');
            $remainingBalance = $booking->total_amount - $totalPaid;
            
            // Validate amount
            if ($request->amount > $remainingBalance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount cannot exceed remaining balance of ₱' . number_format($remainingBalance, 2)
                ]);
            }
            
            if ($request->amount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount must be greater than zero'
                ]);
            }
            
            // Check for existing pending payment
            $existingPending = $booking->payments()
                ->where('status', 'pending')
                ->latest()
                ->first();
            
            if ($existingPending) {
                // Use existing pending payment
                $payment = $existingPending;
            } else {
                // Create new payment record
                $payment = PaymentModel::create([
                    'booking_id' => $booking->id,
                    'payment_reference' => PaymentModel::generatePaymentReference(),
                    'amount' => $request->amount,
                    'payment_method' => 'pending',
                    'status' => 'pending',
                ]);
            }
            
            return response()->json([
                'success' => true,
                'payment' => $payment,
                'booking_reference' => $booking->booking_reference,
                'amount' => $payment->amount,
                'booking_id' => $booking->id
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error initializing payment: ' . $e->getMessage()
            ], 500);
        }
    }
}