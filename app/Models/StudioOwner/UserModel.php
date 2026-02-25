<?php

namespace App\Models\StudioOwner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_users';

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
        'uuid',
        'role',
        'first_name',
        'middle_name',
        'last_name',
        'user_type',
        'email',
        'mobile_number',
        'password',
        'profile_photo',
        'location_id',
        'status',
        'email_verified',
        'verification_token',
        'token_expiry',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'token_expiry' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get the studios owned by the user.
     */
    public function studios()
    {
        return $this->hasMany(\App\Models\StudioOwner\StudiosModel::class, 'user_id');
    }

    /**
     * Get the studio owned by the user (if studio owner).
     */
    public function studio()
    {
        return $this->hasOne(\App\Models\StudioOwner\StudiosModel::class, 'user_id');
    }

    /**
     * Get the freelancer profile if user is a freelancer.
     */
    public function freelancerProfile()
    {
        return $this->hasOne(\App\Models\Freelancer\ProfileModel::class, 'user_id');
    }

    /**
     * Get bookings where this user is the client.
     */
    public function clientBookings()
    {
        return $this->hasMany(\App\Models\BookingModel::class, 'client_id');
    }

    /**
     * Get bookings where this user is the provider.
     */
    public function providerBookings()
    {
        return $this->hasMany(\App\Models\BookingModel::class, 'provider_id');
    }

    /**
     * Get photographer assignments.
     */
    public function photographerAssignments()
    {
        return $this->hasMany(\App\Models\StudioOwner\BookingAssignedPhotographerModel::class, 'photographer_id');
    }

    /**
     * Get assignments made by this user.
     */
    public function assignedPhotographers()
    {
        return $this->hasMany(\App\Models\StudioOwner\BookingAssignedPhotographerModel::class, 'assigned_by');
    }

    /**
     * Get studio photographer profile.
     */
    public function studioPhotographerProfile()
    {
        return $this->hasOne(\App\Models\StudioOwner\StudioPhotographersModel::class, 'photographer_id');
    }

    /**
     * Get the location associated with the user.
     */
    public function location()
    {
        return $this->belongsTo(\App\Models\Admin\LocationModel::class, 'location_id');
    }

    /**
     * Check if user is a studio owner.
     *
     * @return bool
     */
    public function isStudioOwner()
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user is a freelancer.
     *
     * @return bool
     */
    public function isFreelancer()
    {
        return $this->role === 'freelancer';
    }

    /**
     * Check if user is a client.
     *
     * @return bool
     */
    public function isClient()
    {
        return $this->role === 'client';
    }

    /**
     * Check if user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a studio photographer.
     *
     * @return bool
     */
    public function isStudioPhotographer()
    {
        return $this->role === 'studio-photographer';
    }

    /**
     * Scope to filter by role.
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to filter active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}