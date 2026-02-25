<?php

namespace App\Http\Controllers\StudioPhotographer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingModel;
use App\Models\StudioOwner\StudioOnlineGalleryModel;
use App\Models\StudioOwner\BookingAssignedPhotographerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OnlineGalleryController extends Controller
{
    /**
     * Display list of completed bookings assigned to this photographer
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get all completed bookings where this photographer is assigned
        $assignments = BookingAssignedPhotographerModel::where('photographer_id', $userId)
            ->whereHas('booking', function($q) {
                $q->where('status', 'completed')
                  ->where('booking_type', 'studio');
            })
            ->with([
                'booking' => function($q) {
                    $q->with([
                        'client:id,first_name,last_name,email',
                        'category:id,category_name',
                        'packages' => function($p) {
                            $p->where('package_type', 'studio')
                              ->whereHas('studioPackage', function($sp) {
                                  $sp->where('online_gallery', 1);
                              });
                        }
                    ]);
                },
                'studio:id,studio_name'
            ])
            ->get();

        // Extract bookings from assignments and add gallery info
        $bookings = collect();
        
        foreach ($assignments as $assignment) {
            $booking = $assignment->booking;
            
            if ($booking && $booking->packages->isNotEmpty()) {
                $booking->has_gallery = StudioOnlineGalleryModel::where('booking_id', $booking->id)->exists();
                $booking->gallery = StudioOnlineGalleryModel::where('booking_id', $booking->id)->first();
                $booking->formatted_event_date = \Carbon\Carbon::parse($booking->event_date)->format('M d, Y');
                
                $bookings->push($booking);
            }
        }
        
        return view('studio-photographer.view-online-gallery', compact('bookings'));
    }

    /**
     * Get gallery details for a booking (only if assigned to this photographer)
     */
    public function getGalleryDetails($bookingId)
    {
        try {
            $userId = Auth::id();
            
            // Check if photographer is assigned to this booking
            $assignment = BookingAssignedPhotographerModel::where('photographer_id', $userId)
                ->where('booking_id', $bookingId)
                ->whereHas('booking', function($q) {
                    $q->where('status', 'completed');
                })
                ->first();

            if (!$assignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to access this booking\'s gallery.'
                ], 403);
            }

            // Get the booking
            $booking = BookingModel::where('id', $bookingId)
                ->where('booking_type', 'studio')
                ->with(['client:id,first_name,last_name,email'])
                ->firstOrFail();

            // Get existing gallery if any
            $gallery = StudioOnlineGalleryModel::where('booking_id', $bookingId)->first();

            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'event_name' => $booking->event_name,
                    'event_date' => \Carbon\Carbon::parse($booking->event_date)->format('M d, Y'),
                    'client_name' => $booking->client->first_name . ' ' . $booking->client->last_name,
                    'client_email' => $booking->client->email,
                ],
                'gallery' => $gallery,
                'has_gallery' => $gallery ? true : false
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching gallery details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload images for online gallery (only if assigned to this booking)
     */
    public function uploadImages(Request $request, $bookingId)
    {
        try {
            $request->validate([
                'images' => 'required|array|min:1|max:50',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
                'gallery_name' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            $userId = Auth::id();
            
            // Check if photographer is assigned to this booking
            $assignment = BookingAssignedPhotographerModel::where('photographer_id', $userId)
                ->where('booking_id', $bookingId)
                ->whereHas('booking', function($q) {
                    $q->where('status', 'completed');
                })
                ->first();

            if (!$assignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to upload to this booking\'s gallery.'
                ], 403);
            }

            // Get the booking
            $booking = BookingModel::where('id', $bookingId)
                ->where('booking_type', 'studio')
                ->firstOrFail();

            // Check if booking has online gallery package
            $hasOnlineGallery = $booking->packages()
                ->where('package_type', 'studio')
                ->whereHas('studioPackage', function($q) {
                    $q->where('online_gallery', 1);
                })->exists();

            if (!$hasOnlineGallery) {
                return response()->json([
                    'success' => false,
                    'message' => 'This booking does not include online gallery feature.'
                ], 400);
            }

            DB::beginTransaction();

            // Check if gallery already exists
            $gallery = StudioOnlineGalleryModel::where('booking_id', $bookingId)->first();
            
            // Upload images
            $uploadedImages = [];
            
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('studio-online-galleries/' . $bookingId, 'public');
                    $uploadedImages[] = $path;
                }
            }

            if ($gallery) {
                // Update existing gallery
                $existingImages = $gallery->images ?? [];
                $allImages = array_merge($existingImages, $uploadedImages);
                
                $gallery->update([
                    'images' => $allImages,
                    'total_photos' => count($allImages),
                    'gallery_name' => $request->gallery_name ?? $gallery->gallery_name,
                    'description' => $request->description ?? $gallery->description,
                ]);
                
                $message = count($uploadedImages) . ' image(s) added to gallery successfully.';
            } else {
                // Create new gallery
                $gallery = StudioOnlineGalleryModel::create([
                    'booking_id' => $bookingId,
                    'studio_id' => $booking->provider_id,
                    'client_id' => $booking->client_id,
                    'gallery_reference' => StudioOnlineGalleryModel::generateGalleryReference(),
                    'gallery_name' => $request->gallery_name ?? $booking->event_name . ' Gallery',
                    'description' => $request->description,
                    'images' => $uploadedImages,
                    'total_photos' => count($uploadedImages),
                    'status' => 'active',
                    'published_at' => now(),
                ]);
                
                $message = 'Gallery created with ' . count($uploadedImages) . ' image(s) successfully.';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'gallery' => $gallery
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error uploading images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an image from gallery (only if assigned to this booking)
     */
    public function deleteImage(Request $request, $galleryId)
    {
        try {
            $request->validate([
                'image_path' => 'required|string'
            ]);

            $userId = Auth::id();
            
            // Get gallery and check if photographer is assigned to the booking
            $gallery = StudioOnlineGalleryModel::where('id', $galleryId)
                ->with('booking')
                ->firstOrFail();

            // Check if photographer is assigned to this booking
            $assignment = BookingAssignedPhotographerModel::where('photographer_id', $userId)
                ->where('booking_id', $gallery->booking_id)
                ->exists();

            if (!$assignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete images from this gallery.'
                ], 403);
            }

            $images = $gallery->images ?? [];
            
            // Find and remove the image
            if (($key = array_search($request->image_path, $images)) !== false) {
                unset($images[$key]);
                
                // Delete file from storage
                Storage::disk('public')->delete($request->image_path);
                
                // Re-index array
                $images = array_values($images);
                
                $gallery->update([
                    'images' => $images,
                    'total_photos' => count($images)
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully.',
                    'total_photos' => count($images)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image not found.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete entire gallery (only if assigned to this booking)
     */
    public function deleteGallery($galleryId)
    {
        try {
            $userId = Auth::id();
            
            // Get gallery and check if photographer is assigned to the booking
            $gallery = StudioOnlineGalleryModel::where('id', $galleryId)
                ->with('booking')
                ->firstOrFail();

            // Check if photographer is assigned to this booking
            $assignment = BookingAssignedPhotographerModel::where('photographer_id', $userId)
                ->where('booking_id', $gallery->booking_id)
                ->exists();

            if (!$assignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this gallery.'
                ], 403);
            }

            // Delete all images from storage
            $images = $gallery->images ?? [];
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }

            // Delete the gallery record
            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gallery deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting gallery: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update gallery info (only if assigned to this booking)
     */
    public function updateGallery(Request $request, $galleryId)
    {
        try {
            $request->validate([
                'gallery_name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'status' => 'required|in:active,inactive'
            ]);

            $userId = Auth::id();
            
            // Get gallery and check if photographer is assigned to the booking
            $gallery = StudioOnlineGalleryModel::where('id', $galleryId)
                ->with('booking')
                ->firstOrFail();

            // Check if photographer is assigned to this booking
            $assignment = BookingAssignedPhotographerModel::where('photographer_id', $userId)
                ->where('booking_id', $gallery->booking_id)
                ->exists();

            if (!$assignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to update this gallery.'
                ], 403);
            }

            $gallery->update([
                'gallery_name' => $request->gallery_name,
                'description' => $request->description,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gallery updated successfully.',
                'gallery' => $gallery
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating gallery: ' . $e->getMessage()
            ], 500);
        }
    }
}