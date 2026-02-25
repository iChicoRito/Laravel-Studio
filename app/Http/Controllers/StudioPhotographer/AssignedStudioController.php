<?php

namespace App\Http\Controllers\StudioPhotographer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioOwner\StudioPhotographersModel;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioOwner\UserModel;
use App\Models\Admin\CategoriesModel;
use App\Models\StudioOwner\ServicesModel;

class AssignedStudioController extends Controller
{
    /**
     * Display a listing of assigned studios for the authenticated photographer.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated user (photographer)
        $photographerId = auth()->id();
        
        // Fetch assigned studios with related data
        $assignedStudios = StudioPhotographersModel::with([
            'studio' => function($query) {
                $query->with(['user', 'location', 'category']);
            },
            'owner',
            'photographer',
            'specializationService.category' // Changed: Use specializationService instead of photographerServices
        ])
        ->where('photographer_id', $photographerId)
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($assignment) {
            // Get specialization - it's now a service ID
            $assignment->specialization_display = 'N/A';

            if ($assignment->specializationService) {
                // Get service details
                $service = $assignment->specializationService;
                
                // If service has a category, show category name
                if ($service->category) {
                    $assignment->specialization_display = $service->category->category_name;
                } 
                // If no category, show service name
                else {
                    $serviceNames = $service->service_name;
                    
                    // Parse JSON if service_name is stored as JSON
                    if (is_string($serviceNames) && json_decode($serviceNames, true) !== null) {
                        $serviceNames = json_decode($serviceNames, true);
                    }
                    
                    // Ensure it's an array
                    if (is_array($serviceNames) && !empty($serviceNames)) {
                        $assignment->specialization_display = is_array($serviceNames[0]) 
                            ? (isset($serviceNames[0]['name']) ? $serviceNames[0]['name'] : 'Service')
                            : $serviceNames[0];
                    } else if (is_string($serviceNames)) {
                        $assignment->specialization_display = $serviceNames;
                    }
                }
            }
            
            // Get services for this studio (all services, not just assigned ones)
            $studioServices = [];
            if ($assignment->studio) {
                $services = ServicesModel::where('studio_id', $assignment->studio->id)
                    ->with('category')
                    ->get();
                
                foreach ($services as $service) {
                    $categoryName = $service->category ? $service->category->category_name : 'General Services';
                    
                    // Handle JSON array service_name
                    if (is_array($service->service_name)) {
                        foreach ($service->service_name as $serviceItem) {
                            if (!isset($studioServices[$categoryName])) {
                                $studioServices[$categoryName] = [];
                            }
                            
                            if (is_array($serviceItem)) {
                                $studioServices[$categoryName][] = $serviceItem['name'] ?? 'Service';
                            } else {
                                $studioServices[$categoryName][] = $serviceItem;
                            }
                        }
                    } else {
                        // Handle string service_name
                        if (!isset($studioServices[$categoryName])) {
                            $studioServices[$categoryName] = [];
                        }
                        $studioServices[$categoryName][] = $service->service_name;
                    }
                }
            }
            
            $assignment->services_by_category = $studioServices;
            
            return $assignment;
        });
        
        // Get filter options for dropdowns
        $positions = StudioPhotographersModel::where('photographer_id', $photographerId)
            ->distinct()
            ->pluck('position')
            ->filter()
            ->values();
        
        // Get specializations from tbl_services (via specializationService relationship)
        $specializations = StudioPhotographersModel::where('photographer_id', $photographerId)
            ->where('status', 'active')
            ->with('specializationService')
            ->get()
            ->pluck('specializationService.service_name')
            ->filter()
            ->unique()
            ->values();
        
        return view('studio-photographer.view-assigned-studio', compact(
            'assignedStudios',
            'positions',
            'specializations'
        ));
    }

    /**
     * Get studio details for modal via AJAX.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudioDetails($id)
    {
        $photographerId = auth()->id();
        
        // Verify the photographer has access to this studio
        $assignment = StudioPhotographersModel::with([
            'studio' => function($query) {
                $query->with(['user', 'location', 'services.category']);
            },
            'owner',
            'specializationService.category' // Changed: Use specializationService instead of photographerServices
        ])
        ->where('photographer_id', $photographerId)
        ->where('studio_id', $id)
        ->where('status', 'active')
        ->firstOrFail();
        
        $studio = $assignment->studio;
        
        // Format operating days
        $operatingDays = 'N/A';
        if ($studio->operating_days) {
            $daysArray = is_array($studio->operating_days) 
                ? $studio->operating_days 
                : json_decode($studio->operating_days, true);
            
            if ($daysArray && is_array($daysArray)) {
                $operatingDays = implode(', ', 
                    array_map(function($day) {
                        return ucfirst($day);
                    }, $daysArray)
                );
            }
        }
        
        // Format services by category (now using all studio services)
        $servicesByCategory = [];
        
        // Get all studio services
        if ($studio->services) {
            foreach ($studio->services as $service) {
                if ($service->category) {
                    $categoryName = $service->category->category_name;
                    $serviceNames = $service->service_name;
                    
                    // Parse JSON if service_name is stored as JSON
                    if (is_string($serviceNames) && json_decode($serviceNames, true) !== null) {
                        $serviceNames = json_decode($serviceNames, true);
                    }
                    
                    // Ensure it's an array
                    if (!is_array($serviceNames)) {
                        $serviceNames = [$serviceNames];
                    }
                    
                    if (!isset($servicesByCategory[$categoryName])) {
                        $servicesByCategory[$categoryName] = [];
                    }
                    
                    foreach ($serviceNames as $serviceName) {
                        if (!in_array($serviceName, $servicesByCategory[$categoryName])) {
                            $servicesByCategory[$categoryName][] = $serviceName;
                        }
                    }
                }
            }
        }

        // Format services for display (flat array for backward compatibility)
        $formattedServices = [];
        foreach ($servicesByCategory as $category => $services) {
            foreach ($services as $service) {
                $formattedServices[] = $service;
            }
        }
        
        // Determine verification status
        $verificationStatus = '';
        if ($studio->status === 'approved' || $studio->status === 'active') {
            $verificationStatus = 'Verified';
        } elseif ($studio->status === 'pending') {
            $verificationStatus = 'Pending';
        } else {
            $verificationStatus = ucfirst($studio->status);
        }
        
        // Get specialization display name
        $specializationDisplay = 'N/A';
        if ($assignment->specializationService) {
            $service = $assignment->specializationService;
            if ($service->category) {
                $specializationDisplay = $service->category->category_name;
            } else {
                $serviceNames = $service->service_name;
                if (is_string($serviceNames) && json_decode($serviceNames, true) !== null) {
                    $serviceNames = json_decode($serviceNames, true);
                }
                if (is_array($serviceNames) && !empty($serviceNames)) {
                    $specializationDisplay = $serviceNames[0];
                } else if (is_string($serviceNames)) {
                    $specializationDisplay = $serviceNames;
                }
            }
        }
        
        $data = [
            'id' => $studio->id,
            'name' => $studio->studio_name,
            'type' => ucfirst(str_replace('_', ' ', $studio->studio_type)),
            'year_established' => $studio->year_established,
            'description' => $studio->studio_description,
            'logo' => $studio->studio_logo ? asset('storage/' . $studio->studio_logo) : asset('assets/uploads/profile_placeholder.jpg'),
            'status' => $studio->status,
            'verification_status' => $verificationStatus,
            'owner_name' => $assignment->owner ? $assignment->owner->first_name . ' ' . $assignment->owner->last_name : 'Unknown Owner',
            'owner_email' => $assignment->owner ? $assignment->owner->email : 'N/A',
            'owner_mobile' => $assignment->owner ? $assignment->owner->mobile_number : 'N/A',
            'contact_number' => $studio->contact_number,
            'studio_email' => $studio->studio_email,
            'facebook_url' => $studio->facebook_url,
            'instagram_url' => $studio->instagram_url,
            'street' => $studio->street,
            'barangay' => $studio->barangay,
            'province' => $studio->location ? $studio->location->province : 'N/A',
            'municipality' => $studio->location ? $studio->location->municipality : 'N/A',
            'zip_code' => $studio->location ? $studio->location->zip_code : 'N/A',
            'operating_days' => $operatingDays,
            'start_time' => $studio->start_time ? date('g:i A', strtotime($studio->start_time)) : 'N/A',
            'end_time' => $studio->end_time ? date('g:i A', strtotime($studio->end_time)) : 'N/A',
            'max_clients_per_day' => $studio->max_clients_per_day,
            'advance_booking_days' => $studio->advance_booking_days,
            'business_permit' => $studio->business_permit ? asset('storage/' . $studio->business_permit) : null,
            'owner_id_document' => $studio->owner_id_document ? asset('storage/' . $studio->owner_id_document) : null,
            'photographer_position' => $assignment->position,
            'photographer_specialization' => $specializationDisplay,
            'years_experience' => $assignment->years_of_experience,
            'assigned_date' => $assignment->created_at->format('F d, Y'),
            'services' => $formattedServices,
            'services_by_category' => $servicesByCategory
        ];
        
        return response()->json($data);
    }
}