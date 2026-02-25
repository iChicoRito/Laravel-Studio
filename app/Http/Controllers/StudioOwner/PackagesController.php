<?php

namespace App\Http\Controllers\StudioOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StudioOwner\PackageStoreRequest;
use App\Models\StudioOwner\PackagesModel;
use App\Models\StudioOwner\StudiosModel;
use App\Models\Admin\CategoriesModel;
use Illuminate\Support\Facades\Auth;

class PackagesController extends Controller
{
    /**
     * Display a listing of packages.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get packages for the current user
        $packages = PackagesModel::with(['studio', 'category'])
            ->whereHas('studio', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.view-packages', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create()
    {
        $userId = Auth::id();
        
        // Get verified studios for the current user
        $studios = StudiosModel::where('user_id', $userId)
            ->where('status', 'verified')
            ->get();

        // Get all active categories
        $categories = CategoriesModel::where('status', 'active')->get();

        return view('owner.create-packages', compact('studios', 'categories'));
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(PackageStoreRequest $request)
    {
        try {
            // Check if studio belongs to current user
            $studio = StudiosModel::where('id', $request->studio_id)
                ->where('user_id', Auth::id())
                ->where('status', 'verified')
                ->firstOrFail();

            // Create package
            $package = PackagesModel::create([
                'studio_id' => $request->studio_id,
                'category_id' => $request->category_id,
                'package_name' => $request->package_name,
                'package_description' => $request->package_description,
                'package_inclusions' => $request->package_inclusions,
                'duration' => $request->duration,
                'maximum_edited_photos' => $request->maximum_edited_photos,
                'coverage_scope' => $request->coverage_scope ?? '',
                'package_price' => $request->package_price,
                'online_gallery' => $request->online_gallery,          // Added
                'photographer_count' => $request->photographer_count,  // Added
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Package created successfully!',
                'data' => $package
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create package. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified package.
     */
    public function list()
    {
        $userId = Auth::id();
        
        // Get packages for the current user
        $packages = PackagesModel::with(['studio', 'category'])
            ->whereHas('studio', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all active categories for the filter dropdown
        $categories = \App\Models\Admin\CategoriesModel::where('status', 'active')->get();

        return view('owner.packages-list', compact('packages', 'categories'));
    }

    /**
     * Display the specified package.
     */
    public function show($id)
    {
        try {
            $userId = Auth::id();
            
            // Get package with relationships, ensure it belongs to current user
            $package = PackagesModel::with(['studio', 'category'])
                ->whereHas('studio', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $package
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found or you do not have permission to view it.'
            ], 404);
        }
    }
}