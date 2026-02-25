<?php

namespace App\Models\Freelancer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_freelancers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'location_id',
        'brand_name',
        'tagline',
        'bio',
        'years_experience',
        'brand_logo',
        'street',
        'barangay',
        'service_area',
        'starting_price',
        'deposit_policy',
        'portfolio_works',
        'facebook_url',
        'instagram_url',
        'website_url',
        'valid_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'portfolio_works' => 'array',
        'starting_price' => 'decimal:2',
    ];

    /**
     * Get the user associated with the freelancer profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'user_id');
    }

    /**
     * Get the location associated with the freelancer profile.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\LocationModel::class, 'location_id');
    }

    /**
     * Get the categories associated with the freelancer.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Models\Admin\CategoriesModel::class,
            'pvt_freelancer_categories',
            'user_id',
            'category_id'
        )->withTimestamps();
    }

    /**
     * Get the schedule associated with the freelancer.
     */
    public function schedule(): HasOne
    {
        return $this->hasOne(FreelancerScheduleModel::class, 'user_id', 'user_id');
    }

    /**
     * Get the services associated with the freelancer.
     */
    public function services()
    {
        return $this->hasMany(\App\Models\Freelancer\ServiceModel::class, 'user_id', 'user_id');
    }

    /**
     * Get the ratings for the freelancer.
     */
    public function ratings()
    {
        return $this->hasMany(\App\Models\FreelancerRatingModel::class, 'freelancer_id', 'user_id');
    }
}