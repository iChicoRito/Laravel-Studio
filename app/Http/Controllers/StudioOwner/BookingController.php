<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingModel;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioOwner\StudioPhotographersModel;
use App\Models\StudioOwner\BookingAssignedPhotographerModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StudioOwner\UpdateBookingStatusRequest;

class BookingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Get ALL studios owned by this user
        $studioIds = StudiosModel::where('user_id', $userId)->pluck('id')->toArray();
        
        if (empty($studioIds)) {
            return view('owner.view-bookings')->with('bookings', collect([]));
        }
        
        // Get bookings for ALL studios owned by this user
        $bookings = BookingModel::whereIn('provider_id', $studioIds)
            ->where('booking_type', 'studio')
            ->with([
                'client:id,first_name,last_name,email,mobile_number',
                'category:id,category_name',
                'packages',
                'assignedPhotographers' => function($query) {
                    $query->with(['photographer:id,first_name,last_name']);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('owner.view-bookings', compact('bookings'));
    }

    /**
     * Display booking history
     */
    public function history()
    {
        $userId = Auth::id();
        
        // Get ALL studios owned by this user
        $studioIds = StudiosModel::where('user_id', $userId)->pluck('id')->toArray();
        
        if (empty($studioIds)) {
            return view('owner.booking-history')->with('bookings', collect([]));
        }
        
        // Get completed/cancelled bookings for ALL studios
        $bookings = BookingModel::whereIn('provider_id', $studioIds)
            ->where('booking_type', 'studio')
            ->whereIn('status', ['completed', 'cancelled'])
            ->with([
                'client:id,first_name,last_name',
                'category:id,category_name',
                'packages'
            ])
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('owner.booking-history', compact('bookings'));
    }

    /**
     * Get booking details for modal view
     */
    public function getBookingDetails($id)
    {
        try {
            $userId = Auth::id();
            
            // Get ALL studios owned by this user
            $studioIds = StudiosModel::where('user_id', $userId)->pluck('id')->toArray();
            
            if (empty($studioIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No studios found for this owner'
                ], 404);
            }
            
            // Get the booking - check if it belongs to ANY of the owner's studios
            $booking = BookingModel::where('id', $id)
                ->whereIn('provider_id', $studioIds)
                ->where('booking_type', 'studio')
                ->with([
                    'client:id,first_name,last_name,email,mobile_number',
                    'category:id,category_name',
                    'packages',
                    'payments' => function($query) {
                        $query->orderBy('created_at', 'desc');
                    },
                    'assignedPhotographers' => function($query) {
                        $query->with([
                            'photographer:id,first_name,last_name,email',
                            'studioPhotographer'
                        ]);
                    }
                ])
                ->firstOrFail();
            
            // Calculate total paid
            $totalPaid = $booking->payments->where('status', 'succeeded')->sum('amount');
            
            // Get available statuses for dropdown
            $availableStatuses = [];
            
            // Check if all photographers have completed their assignments
            $allPhotographersCompleted = true;
            $hasAssignedPhotographers = $booking->assignedPhotographers->count() > 0;
            
            foreach ($booking->assignedPhotographers as $assignment) {
                if ($assignment->status !== 'completed') {
                    $allPhotographersCompleted = false;
                    break;
                }
            }
            
            // Get maximum photographers allowed based on package
            $maxPhotographers = $this->getMaxPhotographersFromPackage($booking);
            $currentAssignedCount = $booking->assignedPhotographers->count();
            
            // Get package details for display
            $bookingPackage = $booking->packages->first();
            $packageDetails = null;
            
            if ($bookingPackage && $bookingPackage->package_type === 'studio') {
                $packageDetails = \App\Models\StudioOwner\PackagesModel::find($bookingPackage->package_id);
            }
            
            // Owner can only complete booking if:
            // 1. Booking is in 'in_progress' status
            // 2. All assigned photographers have marked as completed
            // 3. Booking is fully paid
            $canOwnerComplete = $booking->status === 'in_progress' && 
                                $allPhotographersCompleted && 
                                $totalPaid >= $booking->total_amount;
            
            return response()->json([
                'success' => true,
                'booking' => $booking,
                'client' => $booking->client,
                'category' => $booking->category,
                'packages' => $booking->packages,
                'payments' => $booking->payments,
                'assignedPhotographers' => $booking->assignedPhotographers,
                'available_statuses' => $availableStatuses,
                'can_owner_complete' => $canOwnerComplete,
                'total_paid' => $totalPaid,
                'status_badge_class' => $booking->getStatusBadgeClass(),
                'payment_status_badge_class' => $booking->getPaymentStatusBadgeClass(),
                'max_photographers' => $maxPhotographers,
                'current_assigned_count' => $currentAssignedCount,
                'package_photographer_count' => $packageDetails->photographer_count ?? 1
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get maximum photographers allowed from the booking's package
     */
    private function getMaxPhotographersFromPackage($booking)
    {
        // Get the booking package
        $bookingPackage = $booking->packages->first();
        
        if (!$bookingPackage) {
            return 1; // Default to 1 if no package
        }
        
        // Get the actual package from tbl_packages based on package_id and package_type
        if ($bookingPackage->package_type === 'studio') {
            $package = \App\Models\StudioOwner\PackagesModel::find($bookingPackage->package_id);
        } else {
            $package = \App\Models\Freelancer\PackagesModel::find($bookingPackage->package_id);
        }
        
        if ($package && isset($package->photographer_count)) {
            return (int) $package->photographer_count;
        }
        
        return 1; // Default to 1 if no photographer_count specified
    }

    /**
     * Get available photographers for assignment
     */
    public function getAvailablePhotographers($bookingId)
    {
        try {
            $userId = Auth::id();
            
            // Get ALL studios owned by this user
            $studioIds = StudiosModel::where('user_id', $userId)->pluck('id')->toArray();
            
            if (empty($studioIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No studios found for this owner'
                ], 404);
            }
            
            // Get the booking - check if it belongs to ANY of the owner's studios
            $booking = BookingModel::where('id', $bookingId)
                ->whereIn('provider_id', $studioIds)
                ->where('booking_type', 'studio')
                ->with(['packages', 'category'])
                ->firstOrFail();
            
            // Get the specific studio for this booking (for photographers)
            $studio = StudiosModel::find($booking->provider_id);
            
            // Don't allow assignment if booking is in progress or completed
            if (in_array($booking->status, ['in_progress', 'completed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot assign photographers to a booking that is in progress or already completed.'
                ]);
            }
            
            // Get required photographer count from package
            $requiredPhotographers = $this->getMaxPhotographersFromPackage($booking);
            $currentAssignedCount = BookingAssignedPhotographerModel::where('booking_id', $bookingId)->count();
            $remainingNeeded = $requiredPhotographers - $currentAssignedCount;
            
            // Get package details for display
            $bookingPackage = $booking->packages->first();
            $packageName = 'N/A';
            $packageDetails = null;
            
            if ($bookingPackage) {
                if ($bookingPackage->package_type === 'studio') {
                    $packageDetails = \App\Models\StudioOwner\PackagesModel::find($bookingPackage->package_id);
                }
                $packageName = $bookingPackage->package_name;
            }
            
            // Check if requirement is already met
            if ($remainingNeeded <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => "This booking already has all {$requiredPhotographers} required photographers assigned."
                ]);
            }
            
            // Get all active studio photographers
            $studioPhotographers = StudioPhotographersModel::where('studio_id', $studio->id)
                ->where('status', 'active')
                ->with(['photographer:id,first_name,last_name'])
                ->get();
            
            // Get already assigned photographer IDs for this booking
            $assignedPhotographerIds = BookingAssignedPhotographerModel::where('booking_id', $bookingId)
                ->pluck('photographer_id')
                ->toArray();
            
            // Filter out already assigned photographers
            $availablePhotographers = [];
            foreach ($studioPhotographers as $sp) {
                if (!in_array($sp->photographer_id, $assignedPhotographerIds)) {
                    $availablePhotographers[] = [
                        'id' => $sp->photographer_id,
                        'name' => $sp->photographer->first_name . ' ' . $sp->photographer->last_name,
                        'position' => $sp->position,
                        'status' => $sp->status,
                        'years_experience' => $sp->years_of_experience,
                        'specialization' => $sp->specialization
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'photographers' => $availablePhotographers,
                'booking' => [
                    'reference' => $booking->booking_reference,
                    'event_name' => $booking->event_name,
                    'event_date' => \Carbon\Carbon::parse($booking->event_date)->format('M d, Y'),
                    'category' => $booking->category->category_name ?? 'N/A'
                ],
                'assignment_info' => [
                    'required_photographers' => $requiredPhotographers,
                    'current_assigned' => $currentAssignedCount,
                    'remaining_needed' => $remainingNeeded,
                    'is_initial_assignment' => ($currentAssignedCount === 0),
                    'package_name' => $packageName,
                    'package_details' => $packageDetails ? [
                        'photographer_count' => $packageDetails->photographer_count,
                        'duration' => $packageDetails->duration,
                        'maximum_edited_photos' => $packageDetails->maximum_edited_photos
                    ] : null
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching available photographers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
    * Assign photographers to booking
    */
    public function assignPhotographers(Request $request, $bookingId)
    {
        try {
            $request->validate([
                'photographer_ids' => 'required|array|min:1',
                'photographer_ids.*' => 'exists:tbl_users,id',
                'assignment_notes' => 'nullable|string|max:500'
            ]);
            
            $userId = Auth::id();
            
            // Get ALL studios owned by this user
            $studioIds = StudiosModel::where('user_id', $userId)->pluck('id')->toArray();
            
            if (empty($studioIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No studios found for this owner'
                ], 404);
            }
            
            // Get the booking - check if it belongs to ANY of the owner's studios
            $booking = BookingModel::where('id', $bookingId)
                ->whereIn('provider_id', $studioIds)
                ->where('booking_type', 'studio')
                ->with(['packages'])
                ->firstOrFail();
            
            // Get the specific studio for this booking
            $studio = StudiosModel::find($booking->provider_id);
            
            // Don't allow assignment if booking is in progress or completed
            if (in_array($booking->status, ['in_progress', 'completed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot assign photographers to a booking that is in progress or already completed.'
                ]);
            }
            
            // Get required photographer count from package
            $requiredPhotographers = $this->getMaxPhotographersFromPackage($booking);
            $currentAssignedCount = BookingAssignedPhotographerModel::where('booking_id', $bookingId)->count();
            
            // Check if we're doing initial assignment or adding more
            if ($currentAssignedCount === 0) {
                // Initial assignment - must assign EXACTLY the required number
                if (count($request->photographer_ids) != $requiredPhotographers) {
                    return response()->json([
                        'success' => false,
                        'message' => "This package requires exactly {$requiredPhotographers} photographer(s). Please select {$requiredPhotographers} photographers."
                    ]);
                }
            } else {
                // Adding more photographers - check if total will equal required number
                $totalAfterAssignment = $currentAssignedCount + count($request->photographer_ids);
                
                if ($totalAfterAssignment > $requiredPhotographers) {
                    return response()->json([
                        'success' => false,
                        'message' => "This package requires a total of {$requiredPhotographers} photographer(s). You currently have {$currentAssignedCount} assigned. You can only add " . ($requiredPhotographers - $currentAssignedCount) . " more."
                    ]);
                }
                
                if ($totalAfterAssignment < $requiredPhotographers) {
                    return response()->json([
                        'success' => false,
                        'message' => "This package requires a total of {$requiredPhotographers} photographer(s). You currently have {$currentAssignedCount} assigned. You need to add " . ($requiredPhotographers - $currentAssignedCount) . " more to complete the required count."
                    ]);
                }
            }
            
            DB::beginTransaction();
            
            $assignedCount = 0;
            foreach ($request->photographer_ids as $photographerId) {
                // Check if already assigned
                $exists = BookingAssignedPhotographerModel::where('booking_id', $bookingId)
                    ->where('photographer_id', $photographerId)
                    ->exists();
                
                if (!$exists) {
                    BookingAssignedPhotographerModel::create([
                        'booking_id' => $bookingId,
                        'studio_id' => $studio->id,
                        'photographer_id' => $photographerId,
                        'assigned_by' => $userId,
                        'status' => 'assigned',
                        'assignment_notes' => $request->assignment_notes,
                        'assigned_at' => now()
                    ]);
                    $assignedCount++;
                }
            }
            
            DB::commit();
            
            // Check if assignment is now complete (all photographers assigned)
            $newTotal = $currentAssignedCount + $assignedCount;
            $isComplete = ($newTotal == $requiredPhotographers);
            
            return response()->json([
                'success' => true,
                'message' => $assignedCount . ' photographer(s) assigned successfully.' . 
                            ($isComplete ? ' All required photographers have been assigned.' : ''),
                'assignment_info' => [
                    'current_assigned' => $newTotal,
                    'required_photographers' => $requiredPhotographers,
                    'remaining_needed' => $requiredPhotographers - $newTotal,
                    'is_complete' => $isComplete
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error assigning photographers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove photographer assignment
     */
    public function removePhotographerAssignment($assignmentId)
    {
        try {
            $userId = Auth::id();
            
            // Get ALL studios owned by this user
            $studioIds = StudiosModel::where('user_id', $userId)->pluck('id')->toArray();
            
            if (empty($studioIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No studios found for this owner'
                ], 404);
            }
            
            $assignment = BookingAssignedPhotographerModel::where('id', $assignmentId)
                ->whereIn('studio_id', $studioIds)
                ->firstOrFail();
            
            // Don't allow removal if booking is in progress or completed
            $booking = BookingModel::find($assignment->booking_id);
            if (in_array($booking->status, ['in_progress', 'completed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot remove photographer from a booking that is in progress or already completed.'
                ]);
            }
            
            $assignment->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Photographer assignment removed successfully.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing assignment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Owner completes the booking (final step)
     */
    public function completeBooking($id)
    {
        try {
            $userId = Auth::id();
            
            // Get ALL studios owned by this user
            $studioIds = StudiosModel::where('user_id', $userId)->pluck('id')->toArray();
            
            if (empty($studioIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No studios found for this owner'
                ], 404);
            }
            
            // Get the booking - check if it belongs to ANY of the owner's studios
            $booking = BookingModel::where('id', $id)
                ->whereIn('provider_id', $studioIds)
                ->where('booking_type', 'studio')
                ->firstOrFail();
            
            // Check if booking is in progress
            if ($booking->status !== 'in_progress') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking must be in progress before it can be completed.'
                ]);
            }
            
            // Check if fully paid
            $totalPaid = $booking->payments()->where('status', 'succeeded')->sum('amount');
            if ($totalPaid < $booking->total_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking must be fully paid before it can be completed.'
                ]);
            }
            
            // Check if all photographers have completed their assignments
            $assignments = BookingAssignedPhotographerModel::where('booking_id', $id)->get();
            
            // If there are no photographers assigned, that's fine
            if ($assignments->count() > 0) {
                foreach ($assignments as $assignment) {
                    if ($assignment->status !== 'completed') {
                        return response()->json([
                            'success' => false,
                            'message' => 'All assigned photographers must mark their assignments as completed before the owner can complete the booking.'
                        ]);
                    }
                }
            }
            
            // Update booking status to completed
            $booking->status = BookingModel::STATUS_COMPLETED;
            $booking->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Booking completed successfully.',
                'booking' => $booking
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error completing booking: ' . $e->getMessage()
            ], 500);
        }
    }
}