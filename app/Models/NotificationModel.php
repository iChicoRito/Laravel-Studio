<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NotificationModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'icon',
        'color',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['time_ago', 'formatted_date', 'is_unread']; // ADD THIS

    /**
     * Boot method to generate UUID
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    /**
     * Scope to get unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope to get read notifications.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
        
        return $this;
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
        
        return $this;
    }

    /**
     * Check if notification is read.
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Get time ago attribute - FIXED
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get formatted created date - FIXED
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }

    /**
     * Get is unread attribute - ADD THIS
     */
    public function getIsUnreadAttribute()
    {
        return is_null($this->read_at);
    }

    /**
     * Get icon based on notification type.
     */
    public function getIconAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Default icons based on type
        $icons = [
            'studio_approved' => 'check-circle',
            'studio_rejected' => 'x-circle',
            'booking_confirmed' => 'calendar-check',
            'payment_received' => 'credit-card',
            'new_message' => 'message-circle',
            'reminder' => 'bell',
        ];
        
        return $icons[$this->type] ?? 'bell';
    }

    /**
     * Get color based on notification type.
     */
    public function getColorAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Default colors based on type
        $colors = [
            'studio_approved' => 'success',
            'studio_rejected' => 'danger',
            'booking_confirmed' => 'info',
            'payment_received' => 'success',
            'new_message' => 'primary',
            'reminder' => 'warning',
        ];
        
        return $colors[$this->type] ?? 'secondary';
    }
}