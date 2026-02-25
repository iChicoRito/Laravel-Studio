<?php

namespace App\Models\StudioOwner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAssignedPhotographerModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_booking_assigned_photographers';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'studio_id',
        'photographer_id',
        'assigned_by',
        'status',
        'assignment_notes',
        'cancellation_reason',
        'assigned_at',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assigned_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the booking associated with the assignment.
     */
    public function booking()
    {
        return $this->belongsTo(\App\Models\BookingModel::class, 'booking_id');
    }

    /**
     * Get the studio associated with the assignment.
     */
    public function studio()
    {
        return $this->belongsTo(\App\Models\StudioOwner\StudiosModel::class, 'studio_id');
    }

    /**
     * Get the photographer (user) assigned.
     */
    public function photographer()
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'photographer_id');
    }

    /**
     * Get the user who assigned the photographer.
     */
    public function assigner()
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'assigned_by');
    }

    /**
     * Get the studio photographer details.
     */
    public function studioPhotographer()
    {
        return $this->belongsTo(\App\Models\StudioOwner\StudioPhotographersModel::class, 'photographer_id', 'photographer_id');
    }

    /**
     * Check if assignment is active.
     */
    public function isActive()
    {
        return in_array($this->status, ['assigned', 'confirmed']);
    }

    /**
     * Mark assignment as confirmed.
     */
    public function markAsConfirmed()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    /**
     * Mark assignment as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark assignment as cancelled.
     */
    public function markAsCancelled($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);
    }
}