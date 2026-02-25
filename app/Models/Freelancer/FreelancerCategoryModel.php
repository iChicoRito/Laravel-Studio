<?php

namespace App\Models\Freelancer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerCategoryModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pvt_freelancer_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
    ];

    /**
     * Get the category associated with the pivot.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\CategoriesModel::class, 'category_id');
    }

    /**
     * Get the user associated with the pivot.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'user_id');
    }
}