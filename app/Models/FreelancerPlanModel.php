<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerPlanModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_freelancer_plans';

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
        'freelancer_id',
        'plan_id',
        'subscription_reference',
        'start_date',
        'end_date',
        'next_billing_date',
        'amount_paid',
        'payment_status',
        'status',
        'plan_snapshot',
        'usage_metrics',
        'cancelled_at',
        'cancellation_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'next_billing_date' => 'date',
        'amount_paid' => 'decimal:2',
        'plan_snapshot' => 'array',
        'usage_metrics' => 'array',
        'cancelled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Status labels
     */
    public const STATUS_LABELS = [
        'active' => 'Active',
        'expired' => 'Expired',
        'cancelled' => 'Cancelled',
        'pending' => 'Pending',
    ];

    /**
     * Payment status labels
     */
    public const PAYMENT_STATUS_LABELS = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
        'refunded' => 'Refunded',
    ];

    /**
     * Get the freelancer associated with this subscription
     */
    public function freelancer()
    {
        return $this->belongsTo(UserModel::class, 'freelancer_id');
    }

    /**
     * Get the freelancer profile
     */
    public function freelancerProfile()
    {
        return $this->belongsTo(\App\Models\Freelancer\ProfileModel::class, 'freelancer_id', 'user_id');
    }

    /**
     * Get the plan associated with this subscription
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlanModel::class, 'plan_id');
    }

    /**
     * Generate a unique subscription reference
     */
    public static function generateSubscriptionReference()
    {
        do {
            $reference = 'FL-SUB-' . strtoupper(uniqid());
        } while (self::where('subscription_reference', $reference)->exists());

        return $reference;
    }

    /**
     * Check if subscription is active
     */
    public function isActive()
    {
        return $this->status === 'active' && 
               $this->end_date >= now()->toDateString() &&
               $this->payment_status === 'paid';
    }

    /**
     * Check if subscription is expiring soon (within 7 days)
     */
    public function isExpiringSoon()
    {
        if (!$this->isActive()) {
            return false;
        }
        
        $daysUntilExpiry = now()->diffInDays($this->end_date, false);
        return $daysUntilExpiry <= 7 && $daysUntilExpiry >= 0;
    }

    /**
     * Update usage metrics
     */
    public function updateUsageMetrics($metrics)
    {
        $currentMetrics = $this->usage_metrics ?? [];
        $this->usage_metrics = array_merge($currentMetrics, $metrics);
        $this->save();
    }

    /**
     * Increment booking count
     */
    public function incrementBookingCount()
    {
        $metrics = $this->usage_metrics ?? [];
        $currentBookings = $metrics['total_bookings'] ?? 0;
        $metrics['total_bookings'] = $currentBookings + 1;
        $metrics['last_booking_at'] = now()->toDateTimeString();
        
        $this->usage_metrics = $metrics;
        $this->save();
    }

    /**
     * Get formatted status
     */
    public function getFormattedStatusAttribute()
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get formatted payment status
     */
    public function getFormattedPaymentStatusAttribute()
    {
        return self::PAYMENT_STATUS_LABELS[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'active' => 'badge-soft-success',
            'expired' => 'badge-soft-secondary',
            'cancelled' => 'badge-soft-danger',
            'pending' => 'badge-soft-warning',
        ];
        
        return $classes[$this->status] ?? 'badge-soft-secondary';
    }

    /**
     * Get payment status badge class
     */
    public function getPaymentStatusBadgeClassAttribute()
    {
        $classes = [
            'paid' => 'badge-soft-success',
            'pending' => 'badge-soft-warning',
            'failed' => 'badge-soft-danger',
            'refunded' => 'badge-soft-secondary',
        ];
        
        return $classes[$this->payment_status] ?? 'badge-soft-secondary';
    }
}