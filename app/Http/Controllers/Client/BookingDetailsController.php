<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioOwner\StudiosModel;
use App\Models\StudioOwner\PackagesModel;
use App\Models\StudioOwner\StudioScheduleModel;
use App\Models\Freelancer\ProfileModel;
use App\Models\Freelancer\PackagesModel as FreelancerPackagesModel;
use App\Models\Freelancer\FreelancerScheduleModel;
use App\Models\Admin\CategoriesModel;
use App\Models\StudioRatingModel;
use App\Models\FreelancerRatingModel;
use Illuminate\Support\Facades\DB;

class BookingDetailsController extends Controller
{
    /**
     * Display booking details for studio or freelancer.
     */
    public function index($type, $id)
    {
        if ($type === 'studio') {
            // Fetch studio details with ratings
            $studio = StudiosModel::whereIn('status', ['approved', 'active', 'verified'])
                ->with(['location', 'category', 'packages', 'schedules', 'user'])
                ->withCount(['ratings as average_rating' => function($query) {
                    $query->select(DB::raw('coalesce(avg(rating), 0)'));
                }])
                ->withCount('ratings')
                ->findOrFail($id);

            // Fetch recent ratings for this studio
            $recentRatings = StudioRatingModel::where('studio_id', $id)
                ->with('client:id,first_name,last_name,profile_photo')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Calculate rating distribution
            $ratingDistribution = [
                5 => StudioRatingModel::where('studio_id', $id)->where('rating', 5)->count(),
                4 => StudioRatingModel::where('studio_id', $id)->where('rating', 4)->count(),
                3 => StudioRatingModel::where('studio_id', $id)->where('rating', 3)->count(),
                2 => StudioRatingModel::where('studio_id', $id)->where('rating', 2)->count(),
                1 => StudioRatingModel::where('studio_id', $id)->where('rating', 1)->count(),
            ];

            // Fetch studio packages grouped by category
            $studioPackages = PackagesModel::where('studio_id', $id)
                ->where('status', 'active')
                ->with('category')
                ->get()
                ->groupBy('category_id');

            // Get category IDs that have active packages
            $categoryIdsWithPackages = $studioPackages->keys()->toArray();

            // Fetch only those categories
            $categories = CategoriesModel::whereIn('id', $categoryIdsWithPackages)
                ->where('status', 'active')
                ->orderBy('category_name', 'asc')
                ->get();

            return view('client.booking-details', compact(
                'studio', 
                'categories', 
                'studioPackages', 
                'type',
                'recentRatings',
                'ratingDistribution'
            ));
        }

        // For freelancer
        $freelancer = ProfileModel::with(['user', 'location', 'categories', 'services', 'schedule'])
            ->whereHas('user', function($query) {
                $query->where('status', 'active');
            })
            ->withCount(['ratings as average_rating' => function($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])
            ->withCount('ratings')
            ->where('user_id', $id)
            ->firstOrFail();

        // Fetch recent ratings for this freelancer
        $recentRatings = FreelancerRatingModel::where('freelancer_id', $id)
            ->with('client:id,first_name,last_name,profile_photo')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate rating distribution
        $ratingDistribution = [
            5 => FreelancerRatingModel::where('freelancer_id', $id)->where('rating', 5)->count(),
            4 => FreelancerRatingModel::where('freelancer_id', $id)->where('rating', 4)->count(),
            3 => FreelancerRatingModel::where('freelancer_id', $id)->where('rating', 3)->count(),
            2 => FreelancerRatingModel::where('freelancer_id', $id)->where('rating', 2)->count(),
            1 => FreelancerRatingModel::where('freelancer_id', $id)->where('rating', 1)->count(),
        ];

        // Fetch freelancer packages grouped by category
        $freelancerPackages = FreelancerPackagesModel::where('user_id', $freelancer->user_id)
            ->where('status', 'active')
            ->with('category')
            ->get()
            ->groupBy('category_id');

        // Get category IDs that have active packages
        $categoryIdsWithPackages = $freelancerPackages->keys()->toArray();

        // Fetch only those categories
        $categories = CategoriesModel::whereIn('id', $categoryIdsWithPackages)
            ->where('status', 'active')
            ->orderBy('category_name', 'asc')
            ->get();

        return view('client.booking-details', compact(
            'freelancer', 
            'categories', 
            'freelancerPackages', 
            'type',
            'recentRatings',
            'ratingDistribution'
        ));
        
        abort(404, 'Invalid type');
    }
}