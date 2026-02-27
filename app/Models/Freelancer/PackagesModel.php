<?php

namespace App\Models\Freelancer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackagesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_freelancer_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'package_name',
        'package_description',
        'package_inclusions',
        'allow_time_customization',
        'duration',
        'maximum_edited_photos',
        'coverage_scope',
        'package_price',
        'online_gallery', // ADDED
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'package_inclusions' => 'array',
        'package_price' => 'decimal:2',
        'online_gallery' => 'boolean', // ADDED
        'allow_time_customization' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the package.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the category that owns the package.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\CategoriesModel::class, 'category_id');
    }

    /**
     * Validation rules for package creation.
     *
     * @var array
     */
    public static $rules = [
        'category_id' => 'required|exists:tbl_categories,id',
        'package_name' => 'required|string|max:255',
        'package_description' => 'required|string',
        'package_inclusions' => 'required|array|min:1',
        'package_inclusions.*' => 'required|string|max:255',
        'duration' => 'required|integer|min:1|max:24',
        'maximum_edited_photos' => 'required|integer|min:1|max:1000',
        'coverage_scope' => 'nullable|string|max:255',
        'package_price' => 'required|numeric|min:0',
        'online_gallery' => 'boolean', // ADDED
        'status' => 'required|in:active,inactive',
    ];

    /**
     * Get time customization label
     */
    public function getTimeCustomizationLabelAttribute(): string
    {
        return $this->allow_time_customization ? 'Flexible' : 'Fixed';
    }

    /**
     * Get duration display text
     */
    public function getDurationDisplayAttribute(): string
    {
        if ($this->allow_time_customization) {
            return 'Client can choose';
        }
        
        return $this->duration ? $this->duration . ' hours' : 'Not specified';
    }

    /**
     * Get time customization badge class
     */
    public function getTimeCustomizationBadgeAttribute(): string
    {
        return $this->allow_time_customization 
            ? 'badge-soft-success' 
            : 'badge-soft-secondary';
    }

    /**
     * Get time customization icon
     */
    public function getTimeCustomizationIconAttribute(): string
    {
        return $this->allow_time_customization 
            ? 'ti ti-clock-edit' 
            : 'ti ti-clock';
    }
}