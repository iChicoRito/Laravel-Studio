<?php

namespace App\Models\Freelancer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerScheduleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_freelancer_schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'operating_days',
        'start_time',
        'end_time',
        'booking_limit',
        'advance_booking',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'operating_days' => 'array',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the user associated with the schedule.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'user_id');
    }

    /**
     * Get the freelancer profile associated with the schedule.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(ProfileModel::class, 'user_id', 'user_id');
    }
}