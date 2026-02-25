<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\UserModel;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    /**
     * Display the freelancers list.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        
        $freelancers = UserModel::where('role', 'freelancer')
            ->with(['freelancerProfile' => function($query) {
                $query->with(['categories', 'location', 'schedule', 'services']);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.view-freelancers', compact('freelancers'));
    }
}